<?php


namespace App\Repositories;


use App\Models\Images\Image;
use App\Models\Locale;
use App\Models\Products\Carts\Cart;
use App\Models\Products\ProductImage;

class CartRepository extends BaseRepository
{
    public function __construct(Cart $model)
    {
        parent::__construct($model);
    }

    public function itemsByCustomerId($customer_id){
        $cart = $this->model->where('customer_id', $customer_id)->get();
        if($cart){
            return $this->model
                ->selectRaw('ci.id,
                        ci.product_id,
                        carts.id as cart_id,
                        v.option_1 as size,
                        v.option_2 as color,
                        v.id as variant_id,
                        v.price as variant_price,
                        p.price,
                        p.sale_price,
                        pt.title as name,
                        img.path as image
                ')
                ->where('carts.customer_id', $customer_id)
                ->leftJoin('cart_items as ci', 'ci.cart_id', '=', 'carts.id')
                ->leftJoin('products as p', 'p.id', '=', 'ci.product_id')
                ->leftJoin('product_translations as pt', 'p.id', '=', 'pt.product_id')
                ->leftJoin('product_images as pi', 'pi.product_id', '=', 'p.id')
                ->leftJoin('images as img', 'pi.image_id', '=', 'img.id')
                ->leftJoin('variants as v', 'v.id', '=', 'ci.variant_id')
                ->where('pi.type', ProductImage::MAIN_TYPE)
                ->where('pt.locale_id', Locale::langCode()->first()->id)
                ->whereIn('pi.image_id', function ($q){
                    $q->select('images.id')->from('images')->where('type', Image::PRODUCT_TYPE);
                })
                ->get();
        }else{
            return [];
        }
    }

    public function itemsByCartId($cart_id){
        return $this->find($cart_id)->items;
    }
}
