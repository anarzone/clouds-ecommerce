<?php

namespace App\Http\Controllers\Admin\V1\Products;

use App\Http\Controllers\Controller;
use App\Services\ProductTypeService;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    private $productTypeService;

    public function __construct(ProductTypeService $productTypeService)
    {
        $this->middleware('auth');
        $this->productTypeService = $productTypeService;
    }

    public function index(){
        return view('admin.v1.products.types.index', $this->productTypeService->index());
    }

    public function get($productTypeId){
        return response([
            'message' => 'success',
            'data' => $this->productTypeService->get($productTypeId),
        ]);
    }

    public function store(Request $request)
    {
        return back()->with('success', $this->productTypeService->save($request));
    }

    public function destroy($product_type_id)
    {
        $this->productTypeService->delete($product_type_id);
        return response()->json([
            'message' => 'success',
            'data' => [],
        ]);
    }
}
