<?php


namespace App\Services;


use App\Models\Locale;
use App\Repositories\LocaleRepository;
use App\Repositories\ProductTypeRepository;

class ProductTypeService
{
    private $productTypeRepository, $localeRepository;

    public function __construct(ProductTypeRepository $productTypeRepository,
                                LocaleRepository $localeRepository
    )
    {
        $this->productTypeRepository = $productTypeRepository;
        $this->localeRepository = $localeRepository;
    }

    public function index(){
        return [
            'productTypes' => $this->productTypeRepository->all(),
            'locales' => $this->localeRepository->all(),
        ];
    }

    public function get($productTypeId){
        return $this->productTypeRepository->withTranslations($productTypeId);
    }

    public function save($request){
        $data = $request->except(['_token', 'name']);

        $productType = $this->productTypeRepository->save($request->get('product_type_id'), $data);

        $locales = $this->localeRepository->all();

        foreach ($locales as $locale){
            $this->productTypeRepository->saveTranslations([
                'product_type_id' => $productType->id,
                'locale_id' => $locale->id
            ], [
                'name' => $request->get('name')[$locale->code],
                'locale_id' => $locale->id,
                'product_type_id' => $productType->id
            ]);
        }

        return $request->get('product_type_id') ? __('messages.productTypeUpdate') : __('messages.productTypeCreate');
    }

    public function delete($product_type_id){
        $this->productTypeRepository->delete($product_type_id);
    }
}
