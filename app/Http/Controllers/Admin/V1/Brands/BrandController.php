<?php

namespace App\Http\Controllers\Admin\V1\Brands;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreBrandRequest;
use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->middleware('auth');
        $this->brandService = $brandService;
    }

    public function index()
    {
        return view('admin.v1.brands.index', $this->brandService->index());
    }

    public function get($brand_id)
    {
        return response()->json([
            'message' => 'success',
            'data' => $this->brandService->edit($brand_id)
        ]);
    }

    public function store(StoreBrandRequest $request)
    {
        $message = $this->brandService->save($request);

        return back()->with('success', $message);
    }

    public function destroy($brand_id)
    {
        $this->brandService->delete($brand_id);
        return response()->json([
            'message' => 'success',
            'data' => [],
        ]);
    }
}
