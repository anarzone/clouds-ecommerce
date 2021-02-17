<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Customers\AddressController;
use App\Http\Controllers\Api\V1\Customers\Auth\AuthController;
use App\Http\Controllers\Api\V1\Categories\CategoryController;
use App\Http\Controllers\Api\V1\Customers\Auth\RecoverPasswordController;
use App\Http\Controllers\Api\V1\Products\ProductController;
use App\Http\Controllers\Api\V1\Products\Carts\CartController;
use App\Http\Controllers\Api\V1\Orders\OrderController;
use App\Http\Controllers\Api\V1\Customers\Auth\SocialLoginController;
use App\Http\Controllers\Api\V1\Rewards\RewardController;
use App\Http\Controllers\Api\V1\Customers\WishlistController;
use App\Http\Controllers\Api\V1\Campaigns\CampaignController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware(['cors', 'json.response'])->prefix('v1')->group(function (){
    Route::name('auth.')->group(function (){
        Route::post('login', [AuthController::class,'login'])->name('login');

        // - Social login - //
            Route::post('facebook', [SocialLoginController::class,'handleGetUserFacebook'])->name('login.facebook')->middleware('guest:api');
            Route::post('google', [SocialLoginController::class,'handleGetUserFromGoogle'])->name('login.google')->middleware('guest:api');
        // - Social login - //

        Route::post('logout', [AuthController::class,'logout'])->name('logout');
        Route::post('register', [AuthController::class,'register'])->name('register');
        Route::get('me', [AuthController::class,'me'])->name('me');
        Route::post('me/update', [AuthController::class,'updatePersonalDetails'])->name('me.update');
        Route::post('password/reset', [RecoverPasswordController::class,'reset'])->name('password.reset');
        Route::post('password/otp/verify', [RecoverPasswordController::class,'verifyOtp'])->name('password.otp.verify');
        Route::post('password/otp/resend', [RecoverPasswordController::class,'resendOtp'])->name('password.otp.resend');
        Route::post('password/recover', [RecoverPasswordController::class,'recover'])->name('password.recover');
        Route::post('password/update', [AuthController::class,'updatePassword'])->name('password.update');
    });

    Route::name('api.')->group(function (){
        // -- Addresses -- //
        Route::prefix('addresses')->name('addresses.')->group(function (){
            Route::get('/', [AddressController::class, 'getCustomerAddresses'])->name('byUserId');
            Route::post('store', [AddressController::class, 'store'])->name('store');
            Route::put('{address_id}/update', [AddressController::class, 'update'])->name('update');
            Route::get('countries', [AddressController::class, 'getCountries'])->name('countries');
            Route::get('{country_id}/cities', [AddressController::class, 'getCitiesByCountry'])->name('citiesByCountry');
            Route::get('{address_id}', [AddressController::class,'show'])->name('show');
            Route::delete('{address_id}/delete', [AddressController::class,'delete'])->name('delete');
        });

        // -- Categories -- //
        Route::prefix('categories')->name('categories.')->group(function (){
            Route::get('/',[CategoryController::class, 'index'])->name('all');
            Route::get('/types',[CategoryController::class, 'getByTypes'])->name('byTypes');
            Route::get('/genders',[CategoryController::class, 'getGenderTypes'])->name('genderTypes');
            Route::get('/ages',[CategoryController::class, 'getAgeTypes'])->name('ageTypes');
            Route::get('{categoryId}/subs', [CategoryController::class, 'getSubCategories'])->name('subCategories');
        });

        // -- Products -- //
        Route::prefix('products')->name('products.')->group(function (){
            // - Filter elements with count - //
                Route::get('categories', [ProductController::class,'getCategories'])->name('categories');
                Route::get('productTypes', [ProductController::class,'getProductTypes'])->name('productTypes');
                Route::get('colors', [ProductController::class,'getColors'])->name('colors');
                Route::get('sizes', [ProductController::class,'getSizes'])->name('sizes');
            // - Filter elements with count - //

            Route::get('filter',[ProductController::class,'filter'])->name('filter');
            Route::get('{productId}/variant', [ProductController::class, '']);
            Route::get('sort/{sortBy}',[ProductController::class,'sort'])->name('sort');
            Route::get('subcategory', [ProductController::class, 'getBySubCategory'])->name('bySubcategory');
            Route::get('category/{categoryId}', [ProductController::class, 'getByParentCategory'])->name('byParentCategory');
            Route::get('/{productId}',[ProductController::class, 'getSingle'])->name('single');
        });

        // -- Wishlist -- //
        Route::prefix('wishlist')->name('wishlist.')->group(function (){
            Route::get('/',[WishlistController::class,'index'])->name('all');
            Route::post('store',[WishlistController::class,'store'])->name('add');
            Route::delete('{wishlistItemId}/delete',[WishlistController::class,'delete'])->name('delete');
            Route::post('{wishlistItemId}/option/update', [WishlistController::class, 'updateOption'])->name('updateOption');
        });

        // -- Cart -- //
        Route::prefix('cart')->name('cart.')->group(function (){
            Route::get('/',[CartController::class,'index'])->name('all');
            Route::post('add',[CartController::class,'storeItem'])->name('add');
            Route::put('{cartItemId}/quantity/update',[CartController::class,'updateQuantity'])->name('updateQuantity');
            Route::put('{cartItemId}/option/update',[CartController::class,'updateVariant'])->name('updateVariant');
            Route::delete('{cartItemId}/delete',[CartController::class,'deleteItem'])->name('remove');
        });


        // -- Orders -- //
        Route::prefix('orders')->name('orders.')->group(function (){
            Route::get('/', [OrderController::class, 'getCustomerOrders'])->name('byCustomer');
            Route::post('store', [OrderController::class,'store'])->name('store');
            Route::get('/{orderId}', [OrderController::class, 'show'])->name('show');
        });

        // -- Rewards -- //
        Route::prefix('reward')->name('reward.')->group(function (){
            Route::get('/', [RewardController::class, 'getCustomerReward'])->name('byCustomer');
            Route::get('/logs', [RewardController::class, 'getLogs'])->name('logs');
        });

        // -- Campaigns -- //
        Route::prefix('campaigns')->name('campaigns.')->group(function (){
            Route::get('{campaignId}/products', [CampaignController::class, 'getProductsById'])->name('products');
        });

        Route::get('/search', [ProductController::class, 'search'])->name('search');
    });
});







