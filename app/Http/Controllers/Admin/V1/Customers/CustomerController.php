<?php

namespace App\Http\Controllers\Admin\V1\Customers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Services\CustomerService;
use App\Services\ImageService;
use App\Services\UserService;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    private $customerService, $imageService, $userService;

    public function __construct(CustomerService $customerService,
                                ImageService $imageService
    )
    {
        $this->middleware('auth');
        $this->customerService = $customerService;
        $this->imageService = $imageService;
    }

    public function index(){
        return view('admin.v1.customers.index', $this->customerService->index());
    }

    public function create(){
        return view('admin.v1.customers.store');
    }

    public function edit($customer_id){
        return view('admin.v1.customers.store', $this->customerService->edit($customer_id));
    }

    public function store(StoreCustomerRequest $request){
        $this->customerService->save($request);
        return redirect()->route('customers.index')->with('success', 'Yeni müştəri yaradıldı');
    }

    public function delete($customer_id){
        $this->customerService->delete($customer_id);
        return response()->json([
            'message' => 'success',
            'data' => []
        ]);
    }
}
