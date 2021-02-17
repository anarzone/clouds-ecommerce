<?php


namespace App\Services;


use App\Repositories\VariantRepository;

class VariantService
{
    private $variantRepository;

    public function __construct(VariantRepository $variantRepository)
    {
        $this->variantRepository = $variantRepository;
    }

    public function save($data){

    }

    public function getByOptions($request){
        return $this->variantRepository->getByOptions($request->all());
    }
}
