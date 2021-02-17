<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Admin\V1\Categories\CategoryController;
use App\Http\Controllers\Admin\V1\Auth\AuthController;
use App\Http\Controllers\Admin\V1\DashboardController;
use App\Http\Controllers\Admin\V1\Customers\CustomerController;
use App\Http\Controllers\Admin\V1\ImageController;
use App\Http\Controllers\Admin\V1\Administration\AdminUserController;
use App\Http\Controllers\Admin\V1\Customers\AddressController;
use App\Http\Controllers\Admin\V1\Products\ProductController;
use App\Http\Controllers\Admin\V1\Brands\BrandController;
use App\Http\Controllers\Admin\V1\Products\ProductTypeController;
use App\Http\Controllers\Admin\V1\Campaigns\CampaignController;


/// -- Admin -- ///
Route::prefix('manage')->group(function (){
    // -- Authorization -- //
    Route::get('login', [AuthController::class,'loginPage'])->name('login.page');
    Route::post('login', [AuthController::class,'login'])->name('login');
    Route::get('logout', [AuthController::class,'logout'])->name('manage.logout');

    // --  Dashboard -- //
    Route::get('/', [DashboardController::class,'index'])->name('manage.home');

    Route::prefix('dashboard')->group(function (){
        Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    });

    // -- Category -- //
    Route::prefix('categories')->name('categories.')->group(function (){
        Route::get('/', [CategoryController::class,'index'])->name('all');
        Route::get('groups',[CategoryController::class,'getGroups'])->name('groups');
        Route::post('groups/positions/update', [CategoryController::class,'updatePosition'])->name('group.position.update');
        Route::get('create', [CategoryController::class,'create'])->name('create');
        Route::post('store', [CategoryController::class,'store'])->name('store');
        Route::get('{category}/get', [CategoryController::class,'get'])->name('get');
        Route::get('{category}/update', [CategoryController::class,'update'])->name('update');
        Route::post('{category}/delete', [CategoryController::class,'destroy'])->name('delete');
    });

    // -- Brand -- //
    Route::prefix('brands')->name('brands.')->group(function (){
        Route::get('/', [BrandController::class,'index'])->name('all');
        Route::get('create', [BrandController::class,'create'])->name('create');
        Route::post('store', [BrandController::class,'store'])->name('store');
        Route::get('{brand}/get', [BrandController::class,'get'])->name('get');
        Route::get('{brand}/update', [BrandController::class,'update'])->name('update');
        Route::post('{brand}/delete', [BrandController::class,'destroy'])->name('delete');
    });

    // -- Customers -- //
    Route::prefix('customers')->name('customers.')->group(function (){
        Route::get('/',[CustomerController::class,'index'])->name('index');
        Route::get('create',[CustomerController::class,'create'])->name('create');
        Route::get('{customer_id}/edit',[CustomerController::class,'edit'])->name('edit');
        Route::post('store',[CustomerController::class,'store'])->name('store');
//        Route::post('image/upload', [CustomerController::class, 'uploadImage'])->name('uploadImage');
        Route::post('{customer_id}/delete', [CustomerController::class, 'delete'])->name('delete');
    });

    // -- Admin Users -- //
    Route::prefix('admins')->name('admins.')->group(function (){
        Route::get('/',[AdminUserController::class, 'index'])->name('index');
        Route::get('create',[AdminUserController::class, 'create'])->name('create');
        Route::get('{adminUserId}/edit',[AdminUserController::class, 'edit'])->name('edit');
        Route::post('store',[AdminUserController::class, 'store'])->name('store');
        Route::post('{adminUserId}/delete',[AdminUserController::class, 'delete'])->name('delete');
    });

    Route::get('{customer_id}/addresses', [AddressController::class, 'customerAddresses'])->name('customerAddresses');

    // -- Products -- //
    Route::prefix('products')->name('products.')->group(function (){
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::get('{productId}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::post('{productId}/delete', [ProductController::class, 'delete'])->name('delete');
        Route::get('/{productId}/images', [ProductController::class, 'getImages'])->name('images');

        Route::prefix('types')->name('types.')->group(function (){
            Route::get('/',[ProductTypeController::class,'index'])->name('index');
            Route::get('create', [ProductTypeController::class,'create'])->name('create');
            Route::post('store', [ProductTypeController::class,'store'])->name('store');
            Route::get('{productType}/get', [ProductTypeController::class,'get'])->name('get');
            Route::get('{productType}/update', [ProductTypeController::class,'update'])->name('update');
            Route::post('{productType}/delete', [ProductTypeController::class,'destroy'])->name('delete');
        });
    });

    // -- Campaigns -- //
    Route::prefix('campaigns')->name('campaigns.')->group(function (){
        Route::get('/', [CampaignController::class, 'index'])->name('index');
        Route::get('create', [CampaignController::class, 'create'])->name('create');
        Route::post('store', [CampaignController::class,'store'])->name('store');
        Route::get('{campaignId}/edit', [CampaignController::class,'edit'])->name('edit');
        Route::post('{campaignId}/delete', [CampaignController::class,'delete'])->name('delete');
        Route::post('types', [CampaignController::class, 'getParentCategoriesByTypes'])->name('parentCategoriesByTypes');
        Route::post('filter', [CampaignController::class, 'filterProducts'])->name('filterProducts');
    });
});


/// -- Image -- //
Route::prefix('images')->name('images.')->group(function (){
    Route::post('{image_id}/get', [ImageController::class, 'get'])->name('get');
    Route::post('upload', [ImageController::class,'upload'])->name('upload');
    Route::post('remove', [ImageController::class,'remove'])->name('remove');
});
