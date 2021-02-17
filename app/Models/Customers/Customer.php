<?php

namespace App\Models\Customers;

use App\Models\Favorite;
use App\Models\Images\Image;
use App\Models\Products\Carts\Cart;
use App\Models\Products\Product;
use App\Models\Rewards\Reward;
use App\Models\Rewards\RewardLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Customer extends Model
{
    use HasFactory;

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const PATH_PROFILE_PIC = 'profiles';

    protected $table = 'customers';
    protected $fillable = [
        'firstname',
        'lastname',
        'birthdate',
        'interested_in',
        'user_id',
        'profile_image_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function profileImage(){
        return $this->belongsTo(Image::class, 'profile_image_id');
    }

    public function addresses(){
        return $this->hasMany(Customer::class,'customer_id');
    }

    public function favoriteProducts(){
        return $this->belongsToMany(Product::class,Favorite::class);
    }

    public function cart(){
        return $this->hasOne(Cart::class, 'customer_id');
    }

    public function reward(){
        return $this->hasOne(Reward::class, 'customer_id');
    }

    public function rewardLogs(){
        return $this->hasManyThrough(RewardLog::class,Reward::class);
    }
}
