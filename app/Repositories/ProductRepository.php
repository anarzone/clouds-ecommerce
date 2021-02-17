<?php


namespace App\Repositories;


use App\Models\Images\Image;
use App\Models\Locale;
use App\Models\Products\Product;
use App\Models\Products\ProductImage;
use App\Repositories\Contractors\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function save($id, $data){
        return $this->model->updateOrCreate(['id' => $id], $data);
    }

    public function saveTranslations($conditions, $data){
        return $this->find($conditions['product_id'])->translations()->updateOrCreate($conditions, $data);
    }

    public function delete($id){
        return $this->find($id)->delete();
    }

    public function getImages($product_id){
        return $this->find($product_id)->images;
    }

    public function getBy($data){
        return $this->model
                ->selectRaw('products.id,
                            products.price,
                            products.sale_price,
                            pt.title as name,
                            img.path as image
                    ')
                ->leftJoin('product_translations as pt', 'products.id', '=', 'pt.product_id')
                ->leftJoin('product_images as pi', 'pi.product_id', '=', 'products.id')
                ->leftJoin('images as img', 'pi.image_id', '=', 'img.id')
                ->leftJoin('product_categories as pc', 'products.id', '=', 'pc.product_id')
                ->where('pi.type', ProductImage::MAIN_TYPE)
                ->where('pt.locale_id', Locale::langCode()->first()->id)
                ->whereIn('pi.image_id', function ($q){
                    $q->select('images.id')->from('images')->where('type', Image::PRODUCT_TYPE);
                })
                ->where('pc.category_id', $data['category_id'])
                ->where('pc.gender_type_id', $data['gender_type_id'])
                ->where('pc.age_type_id', $data['age_type_id'])
                ->get();
    }

    public function getProductsByParentCategory($categoryId, $interestedIn){
        return $this->model->with(['brand','productType','images','categories'])
                    ->whereHas( 'categories', function($query) use ($categoryId, $interestedIn){
                        $query->where('product_categories.category_id', $categoryId);
                        foreach ($interestedIn as $item){
                            $query->where('product_categories.age_type_id', $item);
                        }
                    })->get();
    }

    public function withTranslation($product_id){
        return $this->find($product_id)->with('brand','categories', 'productType','images')->first();
    }

    public function options($productId){
        $variants = $this->model->find($productId)->variants;
        $options = [];

        foreach ($variants as $variant){
            $options['sizes'][] = $variant->option_1;
            $options['colors'][] = $variant->option_2;
        }

        return $options;
    }

    public function saveCategories($product_id, $categories){
        return $this->find($product_id)
            ->categories()
            ->sync($categories, true);
    }

    public function getNew(){
        return $this->model->latest()->get();
    }

    public function getCheapestFirst(){
        return $this->model->orderBy('price','asc')->get();
    }

    public function getExpensiveFirst(){
        return $this->model->orderBy('price','desc')->get();
    }

    public function filter($request){
        $product = $this->model;
        if ($request->has('categoryId')){
            $product = $product->whereHas('categories', function ($query) use ($request){
                $query->where('category_id', $request->categoryId);
            });
        }
        if ($request->has('productTypeId')){
            $product = $product->where('product_type_id', $request->productTypeId);
        }
        if ($request->has('brandId')){
            $product = $product->where('brand_id', $request->brandId);
        }
        if ($request->has('color')){
            $product = $product->whereHas('variants', function ($query) use ($request){
                $query->where('option_2', $request->color);
            });
        }
        if ($request->has('size')){
            $product = $product->whereHas('variants', function ($query) use ($request){
                $query->where('option_1', $request->size);
            });
        }
        if ($request->has('priceMin') && $request->has('priceMax')){
            $product = $product->whereBetween('price', [$request->priceMin, $request->priceMax]);
        }

        return $product->get();
    }

    public function getColorsWithProductCount(){
        return $this->model->selectRaw('v.option_2 as name, count(v.option_2) as cnt')
                    ->leftJoin('variants as v', 'v.product_id', '=', 'products.id')
                    ->groupBy('name')->get();
    }

    public function getSizes(){
        return $this->model->selectRaw('v.option_1 as name')
            ->leftJoin('variants as v', 'v.product_id', '=', 'products.id')
            ->groupBy('name')->get();
    }

    public function search($term){
        return $this->model->select('products.id', 'products.sku', 'products.price', 'products.quantity', 'products.sale_price', 'products.brand_id', 'products.product_type_id')
                            ->leftJoin('product_translations as ptr', 'products.id', '=', 'ptr.product_id')
                            ->leftJoin('product_categories as pc', 'products.id', '=', 'ptr.product_id')
                            ->leftJoin('category_translations as ct', 'pc.category_id', '=', 'ct.category_id')
                            ->leftJoin('brands as b', 'products.brand_id', '=', 'b.id')
                            ->leftJoin('product_types as pt', 'products.product_type_id', '=', 'pt.id')
                            ->leftJoin('product_type_translations as ptt', 'pt.id', '=', 'ptt.product_type_id')
                            ->whereRaw('concat(products.sku, ptr.title, ptr.description, ct.name, b.name, ptt.name) LIKE "%'.$term.'%"')
                            ->groupBy(['products.id', 'products.sku', 'products.price', 'products.quantity', 'products.sale_price', 'products.brand_id', 'products.product_type_id'])
                            ->get();
    }

    public function similarProducts($product_id){
        $categories = $this->find($product_id)->categories;
        $ids = [];
        foreach ($categories as $category){
            $ids[] = $category->id;
        }

        return $this->model->with('brand','categories', 'productType','images')
            ->whereHas('categories', function ($q) use ($ids){
            $q->whereIn('product_categories.category_id', $ids);
        })->skip(0)->take(10)->get();
    }

    public function filterProducts($data){
        return $this->model
            ->whereHas('categories', function ($q) use ($data){
                $q->when(isset($data->categories) && count($data->categories) > 0, function ($q) use ($data){
                    $q->whereIn('product_categories.category_id', $data->categories);
                });
            })
            ->when($data->brandId > 0, function ($q) use ($data){
                $q->where('brand_id', $data->brandId);
            })
            ->when($data->brandId > 0, function ($q) use ($data){
                $q->where('product_type_id', $data->productTypeId);
            })
            ->get();
    }
}
