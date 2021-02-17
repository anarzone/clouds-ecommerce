<?php


namespace App\Services;


use App\Repositories\WishlistRepository;

class WishlistService
{
    private $wishlistRepository;

    public function __construct(WishlistRepository $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
    }

    public function myWishlist($customerId){
        return $this->wishlistRepository->getMyWishlist($customerId);
    }

    public function save($data){
        return $this->wishlistRepository->saveList($data->all());
    }

    public function delete($id){
        return $this->wishlistRepository->delete($id);
    }

    public function updateOption($id, $data){
        return $this->wishlistRepository->updateOption($id, $data);
    }

}
