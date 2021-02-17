<?php


namespace App\Repositories\Contractors;


interface AddressRepositoryInterface
{
    public function save($id, $data);
    public function getUserAddresses($user_id);
}
