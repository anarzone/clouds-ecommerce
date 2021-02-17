<?php


namespace App\Repositories\Contractors;


interface OptionRepositoryInterface
{
    public function findByName($name);
    public function saveValues($id, $data);
}
