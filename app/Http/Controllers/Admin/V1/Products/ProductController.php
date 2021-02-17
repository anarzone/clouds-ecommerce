<?php

namespace App\Http\Controllers\Admin\V1\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreProductRequest;
use App\Services\ProductService;


class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->middleware('auth');
        $this->productService = $productService;
    }

    public function index(){
        return view('admin.v1.products.index', $this->productService->index());
    }

    public function create(){
        return view('admin.v1.products.store', $this->productService->create());
    }

    public function edit($productId){
        return view('admin.v1.products.store', $this->productService->edit($productId));
    }

    public function store(StoreProductRequest $request){
        return redirect()->route('products.index')->with('success',$this->productService->save($request));
    }

    public function delete($product_id){
        $this->productService->delete($product_id);
        return response()->json([
            'message' => 'success',
            'data' => [],
        ]);
    }

    public function getImages($product_id){
        return response()->json([
            'message' => 'success',
            'data' => $this->productService->getImages($product_id),
        ]);
    }
}
