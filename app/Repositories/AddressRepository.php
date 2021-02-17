<?php


namespace App\Repositories;

use App\Models\Customers\Addresses\Address;
use App\Repositories\Contractors\AddressRepositoryInterface;

class AddressRepository extends BaseRepository implements AddressRepositoryInterface
{
    public function __construct(Address $model)
    {
        parent::__construct($model);
    }

    public function save($id, $data)
    {
        return $this->model->updateOrCreate(['id' => $id], $data);
    }

    public function getUserAddresses($user_id){
        return $this->model->where('customer_id', $user_id)->with('country','city')->get();
    }

    public function delete($address_id){
        return $this->find($address_id)->delete();
    }

    public function getById($id){
        return $this->find($id);
    }
}
