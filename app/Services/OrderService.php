<?php


namespace App\Services;


use App\Models\Orders\Order;
use App\Repositories\AddressRepository;
use App\Repositories\CartRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\RewardRepository;


class OrderService
{
    private $orderRepository,
            $orderItemRepository,
            $addressRepository,
            $cartRepository,
            $rewardRepository
    ;

    public function __construct(OrderRepository $orderRepository,
                                OrderItemRepository $orderItemRepository,
                                AddressRepository $addressRepository,
                                CartRepository $cartRepository,
                                RewardRepository $rewardRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->addressRepository = $addressRepository;
        $this->cartRepository = $cartRepository;
        $this->rewardRepository = $rewardRepository;
    }

    public function save($request){
        $cartItems = $this->cartRepository->itemsByCartId($request->cart_id);
        $address = $this->addressRepository->find($request->address_id);

        $order = $this->orderRepository->save(null, [
            'customer_id' => auth('api')->user()->customer->id,
            'debit_card' => $request->debit_card,
            "shipping_address" => $address->address,
            "shipping_country" => $address->country->name,
            "shipping_city" => $address->city->name,
            "shipping_floor" => $address->floor,
            "note" => $address->note ?? ' ',
            'status' => Order::STATUS_PENDING,
            'subtotal' => $request->subtotal,
            'delivery' => $request->delivery,
            'gift_card' => $request->gift_card,
            'reward' => $request->reward,
            'total' => $request->total,
        ]);

        foreach ($cartItems as $cartItem){
            $this->orderItemRepository->save(null, [
                'order_id' => $order->id,
                'price' => $cartItem->price,
                'product_name' => $cartItem->product->translation()->title,
                'quantity' => $cartItem->quantity,
                'size' => $cartItem->variant->option_1,
                'color' => $cartItem->variant->option_2,
                'image' => $cartItem->product->mainImage[0]->path,
            ]);
        }

        return $order;
    }

    public function getByCustomer(){
        return $this->orderRepository->getByCustomerId(auth('api')->user()->customer->id);
    }

    public function getDetails($orderId){
        return $this->orderRepository->getDetails($orderId);
    }
}
