<?php


namespace App\Services;


use App\Helpers\ActionHelper;
use App\Models\Images\Image;
use App\Models\Products\Option;
use App\Models\Products\Product;
use App\Models\Products\ProductImage;
use App\Repositories\AgeTypeRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\GenderTypeRepository;
use App\Repositories\LocaleRepository;
use App\Repositories\OptionRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductTypeRepository;
use App\Repositories\VariantRepository;


class ProductService
{
    use ActionHelper;

    private $productRepository,
            $categoryRepository,
            $localeRepository,
            $brandRepository,
            $productTypeRepository,
            $optionRepository,
            $variantRepository,
            $currencyRepository,
            $genderTypeRepository,
            $ageTypeRepository,
            $imageService;

    public function __construct(ProductRepository $productRepository,
                                CategoryRepository $categoryRepository,
                                LocaleRepository $localeRepository,
                                BrandRepository $brandRepository,
                                ProductTypeRepository $productTypeRepository,
                                CurrencyRepository $currencyRepository,
                                OptionRepository $optionRepository,
                                VariantRepository $variantRepository,
                                GenderTypeRepository $genderTypeRepository,
                                AgeTypeRepository $ageTypeRepository,
                                ImageService $imageService
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->localeRepository = $localeRepository;
        $this->brandRepository = $brandRepository;
        $this->productTypeRepository = $productTypeRepository;
        $this->currencyRepository = $currencyRepository;
        $this->optionRepository = $optionRepository;
        $this->variantRepository = $variantRepository;
        $this->genderTypeRepository = $genderTypeRepository;
        $this->ageTypeRepository = $ageTypeRepository;
        $this->imageService = $imageService;
    }

    public function index(){
        return [
            'products' => $this->productRepository->all()
        ];
    }

    public function create(){
        return [
            'categories' => $this->categoryRepository->parents(),
            'locales' => $this->localeRepository->all(),
            'brands' => $this->brandRepository->all(),
            'productTypes' => $this->productTypeRepository->all(),
            'currencies' => $this->currencyRepository->all(),
            'genderTypes' => $this->genderTypeRepository->withTranslation(),
            'ageTypes' => $this->ageTypeRepository->withTranslation(),
        ];
    }

    public function edit($id){
        return [
            'product' => $this->productRepository->find($id),
            'options' => $this->productRepository->options($id),
            'categories' => $this->categoryRepository->withTranslation(),
            'locales' => $this->localeRepository->all(),
            'brands' => $this->brandRepository->all(),
            'productTypes' => $this->productTypeRepository->all(),
            'currencies' => $this->currencyRepository->all(),
            'genderTypes' => $this->genderTypeRepository->withTranslation(),
            'ageTypes' => $this->ageTypeRepository->withTranslation(),
        ];
    }

    public function save($request){
        $colorValues = explode(",", $request->colors);
        $sizeValues = explode(",", $request->sizes);

        $colorOptionId = $this->optionRepository->findByName(Option::COLOR)->id;
        $sizeOptionId = $this->optionRepository->findByName(Option::SIZE)->id;

        foreach ($colorValues as $colorVal){
            $this->optionRepository->saveValues([
                'name' => strtolower($colorVal)
            ], [
                'option_id' => $colorOptionId,
                'name' => strtolower($colorVal)
            ]);
        }

        foreach ($sizeValues as $sizeVal){
            $this->optionRepository->saveValues([
                'name' => strtolower($sizeVal)
            ], [
                'option_id' => $sizeOptionId,
                'name' => strtolower($sizeVal)
            ]);
        }

        $product = $this->productRepository->save($request->get('product_id'),[
            'sku' => $request->sku,
            'brand_id' => $request->brand_id,
            'product_type_id' => $request->product_type_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
        ]);

        if($request->has('product_id')){
            $this->variantRepository->deleteByProductId($request->get('product_id'));
        }

        foreach ($request->variants as $key => $variant){
            $this->variantRepository->save(isset(explode('/', $key)[2]) ? explode('/', $key)[2] : null,
            [
                'option_1' => explode('/', $key)[0],
                'option_2' => explode('/', $key)[1],
                'product_id' => $product->id,
                'price' => $variant['price'],
                'quantity' => $variant['quantity'],
                'sku' => $variant['sku'],
            ]);
        }


        if(isset($request->image_ids[0])){
            $imageIds = [];
            foreach (explode(",", $request->image_ids[0]) as $id){
                $imageIds[$id] = ['type' => ProductImage::SECONDARY_TYPE];
            }

            $product->images()->sync($imageIds, false);
        }


        if($request->has('main_image')){
            $mainImage = $this->imageService->upload($request->main_image, [
                'dir' => Product::PATH_PRODUCT_IMAGES,
                'type' => Image::PRODUCT_TYPE,
                'id' => null
            ]);

            $product->mainImage()->sync([$mainImage->id => ['type' => ProductImage::MAIN_TYPE]], true);
        }

        $catData = [];


        foreach ($request->categoryData as $data){
            $catData[$data['category_id']] = ['gender_type_id' => $data['gender_type_id'], 'age_type_id' => $data['age_type_id']];
        }


        $this->productRepository->saveCategories($product->id, $catData);

        $locales = $this->localeRepository->all();

        foreach ($locales as $locale){
            $this->productRepository->saveTranslations([
                'product_id' => $product->id,
                'locale_id' => $locale->id
            ], [
                'title' => $request->get('title')[$locale->code],
                'description' => $request->get('description')[$locale->code],
                'locale_id' => $locale->id,
                'product_id' => $product->id
            ]);
        }

        return $request->get('product_id') ? __('messages.productUpdate') : __('messages.productCreate');
    }

    public function delete($id){
        return $this->productRepository->delete($id);
    }

    public function getImages($product_id){
        return $this->productRepository->getImages($product_id);
    }

    public function getBy($request){
        return $this->productRepository->getBy([
            'category_id' => $request->category_id,
            'gender_type_id' => $request->gender_type_id,
            'age_type_id' => $request->age_type_id,
        ]);
    }

    public function getBySubCategory($categoryId){
        return $this->categoryRepository->products($categoryId);
    }

    public function getByParentCategory($categoryId){
        $interestedIn = [];

        if($user = auth('api')->user()){
            $customer = $user->customer;
            $interestedIn = $customer->interested_in ? explode(',', $customer->interested_in) : [];
        }

        return $this->productRepository->getProductsByParentCategory($categoryId, $interestedIn);
    }

    public function getSingle($product_id){
        return $this->productRepository->withTranslation($product_id);
    }

    public function getSimilar($product_id){
        return $this->productRepository->similarProducts($product_id);
    }

    public function sort($sortBy){
        switch ($sortBy){
            case Product::SORT_NEW:
                return $this->productRepository->getNew();
                break;
            case Product::SORT_LOWEST_PRICE:
                return $this->productRepository->getCheapestFirst();
                break;
            case Product::SORT_HIGHEST_PRICE:
                return $this->productRepository->getExpensiveFirst();
                break;
        }
    }

    public function filter($request){
        return $this->productRepository->filter($request);
    }

    public function getCategories(){
        return $this->categoryRepository->groupBySlugWithCount();
    }

    public function getProductTypes(){
        return $this->productTypeRepository->getWithProductCount();
    }

    public function getColors(){
        return $this->productRepository->getColorsWithProductCount();
    }

    public function getSizes(){
        return $this->productRepository->getSizes();
    }

    public function search($term){
        return $this->productRepository->search($term);
    }
}
