<?php

namespace App\Http\Controllers\Api\V1\Customers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreAddressRequest;
use App\Http\Resources\Api\V1\Address;
use App\Services\AddressService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class AddressController extends Controller
{
    private $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->middleware('auth:api');
        $this->addressService = $addressService;
    }

    public function store(StoreAddressRequest $request){
        return response()->json([
            'message' => 'New address created',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_CREATED,
            'data' => new Address($this->addressService->save($request)),
        ], Response::HTTP_CREATED);
    }

    public function update($address_id, StoreAddressRequest $request){
        $this->addressService->save($request->merge(['address_id' => $address_id]));

        return response()->json([
            'message' => 'Address updated',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_CREATED,
            'data' => [
                $this->addressService->save($request->merge(['address_id' => $address_id]))
            ]
        ], Response::HTTP_CREATED);
    }

    public function getAll(){
        return response()->json([
            'message' => 'Retrieve All addresses',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => $this->addressService->getAll(),
        ]);
    }

    public function getCustomerAddresses(){
        return response()->json([
            'message' => 'Retrieve user addresses',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => Address::collection($this->addressService->getAddressesByUserId(auth()->user()->customer->id)),
        ]);
    }

    public function getCountries(){
        return response()->json([
            'message' => 'Get all countries',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => $this->addressService->getCountries(),
        ]);
    }

    public function getCitiesByCountry($country_id){
        return response()->json([
            'message' => 'Get cities of country',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => $this->addressService->getCitiesByCountry($country_id),
        ]);
    }

    public function show($id){
        return response()->json([
            'message' => 'Retrieved address',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => new Address($this->addressService->getById($id)),
        ]);
    }

    public function delete($id){
        $this->addressService->delete($id);
        return response()->json([
            'message' => 'Deleted address',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => [],
        ]);
    }
}
