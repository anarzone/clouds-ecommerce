<?php


namespace App\Services;


use App\Models\Customers\Customer;
use App\Models\Images\Image;
use App\Repositories\CustomerRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class CustomerService
{
    private $customerRepository, $imageService, $userRepository;

    public function __construct(CustomerRepository $customerRepository,
                                ImageService $imageService,
                                UserRepository $userRepository
    )
    {
        $this->customerRepository = $customerRepository;
        $this->imageService = $imageService;
        $this->userRepository = $userRepository;
    }

    public function index(){
        return [
            'customers' => $this->customerRepository->all(),
        ];
    }

    public function edit($customer_id){
        return [
            'customer' => $this->customerRepository->find($customer_id),
        ];
    }

    public function save($request){
        return $this->customerRepository->save($request->customer_id, [
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'birthdate' => $request->birthdate,
                    'interested_in' => $request->interested_in,
                    'profile_image_id' => $request->hasFile('profilePic') ? $this->imageService->upload($request->file('profilePic'), [
                        'dir' => Customer::PATH_PROFILE_PIC,
                        'type' => Image::CUSTOMER_TYPE,
                        'id' => $request->image_id
                    ])->id : null,
                    'user_id' => $this->userRepository->save($request->user_id,[
                        'email' => $request->get('email'),
                        'password' => Hash::make($request->password),
                    ])->id
                ]);
    }

    public function delete($customer_id){
        $this->customerRepository->delete($customer_id);
    }

    public function addFavorite($product_id, $customer_id){
        $this->customerRepository->addFavorite($product_id, $customer_id);
    }

    public function removeFavorite($product_id, $customer_id){
        $this->customerRepository->removeFavorite($product_id, $customer_id);
    }

    public function favoriteProducts($customer_id){
        return $this->customerRepository->favoriteProducts($customer_id);
    }
}
