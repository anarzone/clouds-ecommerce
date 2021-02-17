<?php


namespace App\Services;


use App\Repositories\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function save($data){
        return $this->userRepository->save($data['id'], [
            'email' => $data['email'],
            'password' => $data['password']
        ]);
    }

    public function updatePassword($id, $password){
        return $this->userRepository->updatePassword($id, $password);
    }
}
