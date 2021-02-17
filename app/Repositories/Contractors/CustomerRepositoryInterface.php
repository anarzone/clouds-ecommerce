<?php


namespace App\Repositories\Contractors;


interface CustomerRepositoryInterface
{
    public function save($id, $data);
    public function delete($id);
}
