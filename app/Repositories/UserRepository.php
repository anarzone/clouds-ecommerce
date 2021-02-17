<?php


namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contractors\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;


class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function updatePassword($id, $password){
        return $this->find($id)->update(['password' => Hash::make($password)]);
    }
}
