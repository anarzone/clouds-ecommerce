<?php


namespace App\Repositories;


use App\Models\Stuff\Admin;
use App\Repositories\Contractors\AdminUserInterface;


class AdminUserRepository extends BaseRepository implements AdminUserInterface
{
    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }

    public function save($id, $data)
    {
        return $this->model->updateOrCreate(['id' => $id], $data);
    }

    public function delete($adminUserId){
        $this->find($adminUserId)->delete();
    }
}
