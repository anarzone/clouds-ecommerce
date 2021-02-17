<?php


namespace App\Repositories;
use App\Models\Products\Carts\CartItem;


class CartItemRepository extends BaseRepository
{
    public function __construct(CartItem $model)
    {
        parent::__construct($model);
    }

    public function delete($id){
        $this->model->find($id)->delete();
    }
}
