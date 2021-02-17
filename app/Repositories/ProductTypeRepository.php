<?php


namespace App\Repositories;


use App\Models\Locale;
use App\Models\Products\ProductType;


class ProductTypeRepository extends BaseRepository
{
    public function __construct(ProductType $model)
    {
        parent::__construct($model);
    }

    public function getWithProductCount(){
        return $this->model->selectRaw('product_types.id, name, slug, (Select count(*) from products where product_types.id=products.product_type_id) as cnt')
                            ->leftJoin('product_type_translations as ptt', 'product_types.id', '=', 'ptt.product_type_id')
                            ->where('ptt.locale_id', Locale::langCode()->first()->id)
                            ->get();
    }

    public function withTranslations($productTypeId){
        return $this->find($productTypeId)->load('translations');
    }

    public function saveTranslations($conditions, $data){
        return $this->find($conditions['product_type_id'])->translations()->updateOrCreate($conditions, $data);
    }

    public function delete($product_type_id){
        $this->find($product_type_id)->delete();
    }
}
