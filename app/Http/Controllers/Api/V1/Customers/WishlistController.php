<?php

namespace App\Http\Controllers\Api\V1\Customers;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreWishlistRequest;
use App\Http\Resources\Api\V1\ProductList;
use App\Http\Resources\Api\V1\Wishlist;
use App\Services\WishlistService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    private $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
        $this->middleware('auth:api');
        $this->wishlistService = $wishlistService;
    }

    public function index(){
        $products = $this->wishlistService->myWishlist(auth('api')->user()->customer->id);
        return response()->json([
            'message' => 'Retrieved wishlist',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' =>  $products ? Wishlist::collection($products) : []
        ]);
    }

    public function store(StoreWishlistRequest $request){
        $this->wishlistService->save($request->merge(['customer_id' => auth('api')->user()->customer->id]));
        return response()->json([
            'message' => 'Store wishlist item',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' =>  []
        ]);
    }

    public function delete($id){
        $this->wishlistService->delete($id);
        return response()->json([
            'message' => 'Deleted wishlist item',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' =>  []
        ]);
    }

    public function updateOption($id, Request $request){
        $validator = Validator::make($request->all(), [
            'value' => 'required|string',
            'key' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => "The given data is invalid",
                'status' => config('statuses.error'),
                'statusCode' =>  Response::HTTP_UNPROCESSABLE_ENTITY,
                "errors" => $validator->errors()
            ]);
        }

        $this->wishlistService->updateOption($id, ['field' => $request->key, 'val' => $request->value]);

        return response()->json([
            'message' => 'Updated product option',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' =>  []
        ]);
    }
}
