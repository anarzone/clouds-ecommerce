<?php


namespace App\Services;


use App\Repositories\AddressRepository;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\DB;

class AddressService
{
    private $addressRepository, $customerRepository;

    public function __construct(AddressRepository $addressRepository,
                                CustomerRepository $customerRepository
    )
    {
        $this->addressRepository = $addressRepository;
        $this->customerRepository = $customerRepository;
    }

    public function save($request){
        return $this->addressRepository->save($request->address_id, [
            'address' => $request->address,
            'floor' => $request->floor,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'post_code' => $request->post_code,
            'phone' => $request->phone,
            'customer_id' => auth('api')->user()->customer->id,
        ]);
    }

    public function getAll(){
        return $this->addressRepository->all();
    }

    public function getAddressesByUserId($user_id){
        return $this->addressRepository->getUserAddresses($user_id);
    }

    public function getCountries(){
        return DB::table('countries')->select('id','name','phone_code')->get();
    }

    public function getCitiesByCountry($country_id){
        return DB::table('cities')->select('id','name')->where('country_id', $country_id)->get();
    }

    public function getById($id){
        return $this->addressRepository->getById($id);
    }

    public function delete($id){
        $this->addressRepository->delete($id);
    }
}
