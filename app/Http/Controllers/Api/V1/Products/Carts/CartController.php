<?php

namespace App\Http\Controllers\Api\V1\Products\Carts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CartItem;
use App\Services\CartService;
use App\Services\VariantService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    private $cartService, $variantService;

    public function __construct(CartService $cartService, VariantService $variantService)
    {
        $this->middleware('auth:api');
        $this->cartService = $cartService;
        $this->variantService = $variantService;
    }

    public function index(){
        return response()->json([
            'message' => 'Retrieved cart items',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => $this->cartService->items(auth('api')->user()->customer->id),
        ]);
    }

    public function storeItem(Request $request){
        $validated = Validator::make($request->all(),[
            'product_id' => 'required|numeric',
            'item_id' => 'sometimes|numeric',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'size' => 'required|string',
            'color' => 'required|string',
        ]);

        if ($validated->fails()){
            return response([
                'message' => 'Wrong credentials',
                'status' => config('statuses.ok'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'data' => [
                    'errors' => $validated->getMessageBag()
                ]
            ]);
        }

        return response()->json([
            'message' => 'Item added to cart',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_CREATED,
            'data' => new CartItem($this->cartService->saveItem($request)),
        ], Response::HTTP_CREATED);
    }

    public function updateQuantity($itemId, Request $request){
        $validated = Validator::make($request->all(),[
            'quantity' => 'required|numeric',
        ]);

        if ($validated->fails()){
            return response([
                'message' => 'Wrong credential',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'data' => [
                    'errors' => $validated->getMessageBag()
                ]
            ]);
        }

        return response()->json([
            'message' => 'Quantity updated successfully',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_CREATED,
            'data' => $this->cartService->updateQuantity($itemId, $request->quantity)
        ], Response::HTTP_CREATED);
    }

    public function updateVariant($itemId, Request $request){
        return response()->json([
            'message' => 'Variant updated successfully',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_CREATED,
            'data' => $this->cartService->updateVariant($itemId, $request),
        ]);
    }

    public function deleteItem($itemId){
        $this->cartService->deleteItem($itemId);

        return response()->json([
            'message' => 'Cart item deleted successfully',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => []
        ]);
    }
}
