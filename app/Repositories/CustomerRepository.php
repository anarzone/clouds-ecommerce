<?php


namespace App\Repositories;


use App\Models\Customers\Customer;
use App\Repositories\Contractors\CustomerRepositoryInterface;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }

    public function save($id, $data){
        return $this->model->updateOrCreate(['id' => $id], $data);
    }

    public function delete($id)
    {
        $this->find($id)->delete();
    }

    public function addFavorite($product_id, $customer_id, $data){
        $this->find($customer_id)->favoriteProducts()->attach($product_id, $data);
    }

    public function removeFavorite($product_id, $customer_id){
        $this->find($customer_id)->whereHas('favoriteProducts', function ($query) use ($product_id){
            $query->where('product_id', $product_id);
        })->first()->favoriteProducts()->detach();
    }

    public function favoriteProducts($customer_id){
        return $this->find($customer_id)->favoriteProducts;
    }

    public function getReward($customer_id){
        return $this->find($customer_id)->reward;
    }

    public function getRewardLogs($customer_id){
        return $this->find($customer_id)->rewardLogs;
    }
}
