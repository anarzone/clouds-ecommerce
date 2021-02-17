<?php


namespace App\Services;


use App\Repositories\CartItemRepository;
use App\Repositories\CartRepository;
use App\Repositories\VariantRepository;


class CartService
{
    private $cartRepository,
            $cartItemRepository,
            $variantRepository;

    public function __construct(CartRepository $cartRepository,
                                CartItemRepository $cartItemRepository,
                                VariantRepository $variantRepository
    )
    {
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->variantRepository = $variantRepository;
    }

    public function items($customer_id){
        return $this->cartRepository->itemsByCustomerId($customer_id);
    }

    public function saveItem($request){
        $customer = auth('api')->user()->customer;

        $cart = $this->cartRepository->save($customer->cart ? $customer->cart->id : null, [
            'customer_id' => $customer->id
        ]);

        return $this->cartItemRepository->save($request->get('item_id'), [
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'cart_id' => $cart->id,
            'variant_id' => $this->variantRepository->getByOptions(['size' => $request->size, 'color' => $request->color])->id
        ]);
    }

    public function updateQuantity($id, $quantity){
        return $this->cartItemRepository->save($id, [
            'quantity' => $quantity
        ]);
    }

    public function updateVariant($itemId, $request){
        $variant = $this->variantRepository->getByOptions(['size'=>$request->size, 'color' => $request->color]);
        return $this->cartItemRepository->save($itemId, [
            'variant_id' => $variant->id
        ]);
    }

    public function deleteItem($itemId){
        return $this->cartItemRepository->delete($itemId);
    }
}
