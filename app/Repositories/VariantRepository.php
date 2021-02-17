<?php


namespace App\Repositories;


use App\Models\Products\Variant;
use App\Repositories\Contractors\VariantRepositoryInterface;


class VariantRepository extends BaseRepository implements VariantRepositoryInterface
{
    public function __construct(Variant $model)
    {
        parent::__construct($model);
    }

    public function deleteByProductId($productId){
        $this->model->where('product_id',$productId)->delete();
    }

    public function getByOptions($options){
        return $this->model->where("option_1", $options['size'])->where("option_2", $options['color'])->first();
    }
}
