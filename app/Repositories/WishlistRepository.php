<?php


namespace App\Repositories;

use App\Models\Customers\Wishlist;
use App\Models\Images\Image;
use App\Models\Locale;
use App\Models\Products\ProductImage;


class WishlistRepository extends BaseRepository
{
    public function __construct(Wishlist $model)
    {
        parent::__construct($model);
    }

    public function getMyWishlist($customerId){
        $wishlists = $this->model->where('customer_id', $customerId)->get();

        if($wishlists){
            return $this->model
                    ->selectRaw('favorites.id,
                        favorites.product_id,
                        favorites.color,
                        favorites.size,
                        favorites.price,
                        favorites.sale_price,
                        pt.title as name,
                        img.path as image,
                        (Select price from variants where option_1 = favorites.size and option_2 = favorites.color and product_id = p.id) as variant_price
                ')
                ->where('customer_id', $customerId)
                ->leftJoin('products as p', 'p.id', '=', 'favorites.product_id')
                ->leftJoin('product_translations as pt', 'p.id', '=', 'pt.product_id')
                ->leftJoin('product_images as pi', 'pi.product_id', '=', 'p.id')
                ->leftJoin('images as img', 'pi.image_id', '=', 'img.id')
                ->where('pi.type', ProductImage::MAIN_TYPE)
                ->where('pt.locale_id', Locale::langCode()->first()->id)
                ->whereIn('pi.image_id', function ($q){
                    $q->select('images.id')->from('images')->where('type', Image::PRODUCT_TYPE);
                })
                ->get();
        }

        return [];
    }

    public function saveList($data)
    {
        return $this->model->create($data);
    }

    public function delete($id){
        return $this->find($id)->delete();
    }

    public function updateOption($id, $data){
        return $this->find($id)->update([$data['field'] => $data['val']]);
    }
}
