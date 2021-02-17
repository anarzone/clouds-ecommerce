<?php

namespace App\Http\Controllers\Admin\V1\Customers;

use App\Http\Controllers\Controller;
use App\Services\AddressService;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    private $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function customerAddresses($customer_id){
        return response()->json([
            'message' => 'success',
            'data' => $this->addressService->getAddressesByUserId($customer_id)
        ]);
    }
}
