<?php

namespace App\Http\Controllers\Api\V1\Customers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Product;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->middleware('auth:api');
        $this->customerService = $customerService;
    }

    public function wishlist(){
        return response()->json([
            'message' => 'Retrieved wishlist',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' =>  Product::collection($this->customerService->favoriteProducts(auth('api')->user()->customer->id))
        ]);
    }

    public function addToList(Request $request){
        $this->customerService->addFavorite($request, auth('api')->user()->customer->id);
        return response()->json([
            'message' => 'Added to wishlist',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => []
        ]);
    }

    public function removeFromList($product_id){
        $this->customerService->removeFavorite($product_id, auth('api')->user()->customer->id);
        return response()->json([
            'message' => 'Removed from wishlist',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => []
        ]);
    }
}
