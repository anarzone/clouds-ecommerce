<?php


namespace App\Services;


use App\Http\Requests\V1\StoreBrandRequest;
use App\Repositories\BrandRepository;

class BrandService
{
    protected $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index(){
        return [
            'brands' => $this->brandRepository->all(),
        ];
    }

    public function delete($brand_id){
        $this->brandRepository->find($brand_id)->delete();
    }

    public function edit($category_id){
        return $this->brandRepository->find($category_id);
    }

    public function getAll(){
        return $this->brandRepository->all();
    }

    public function save($request){
        $this->brandRepository->save($request->get('brand_id'), $request->except(['_token']));

        return $request->get('brand_id') ? __('messages.brandUpdate') : __('messages.brandCreate');
    }

}
