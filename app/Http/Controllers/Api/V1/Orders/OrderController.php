<?php

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreOrderRequest;
use App\Http\Resources\Api\V1\Order;
use App\Http\Resources\Api\V1\OrderItem;
use App\Services\OrderService;
use App\Services\RewardService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    private $orderService, $rewardService;

    public function __construct(OrderService $orderService, RewardService $rewardService)
    {
        $this->orderService = $orderService;
        $this->rewardService = $rewardService;
        $this->middleware('auth:api');
    }

    public function store(StoreOrderRequest $request){
        $order = $this->orderService->save($request);
        $this->rewardService->save([
            'total' => $request->total,
            'reward' => $request->reward,
            'orderId' => $order->id
        ]);
        return response()->json([
            'message' => "Order created successfully",
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_CREATED,
            "data" => [],
        ], Response::HTTP_CREATED);
    }

    public function getCustomerOrders(){
        return response()->json([
            'message' => "Retrieved orders",
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_CREATED,
            'data' => OrderItem::collection($this->orderService->getByCustomer()),
        ]);
    }

    public function show($orderId){
        return response()->json([
            'message' => "Retrieved orders",
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_CREATED,
            'data' => new Order($this->orderService->getDetails($orderId)),
        ]);
    }
}
