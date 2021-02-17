<?php


namespace App\Repositories;


use App\Models\Orders\Order;

class OrderRepository extends BaseRepository
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function getByCustomerId($customer_id){
        return $this->model->selectRaw('order_items.order_id as id, sum(order_items.quantity) as pieces, image')
            ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.customer_id', $customer_id)
            ->groupBy(['order_items.id', 'image'])
            ->get();
    }

    public function getDetails($orderId){
        return $this->find($orderId);
    }
}
