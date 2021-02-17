<?php

namespace App\Http\Controllers\Admin\V1\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->middleware('auth');
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('admin.v1.categories.index', $this->categoryService->index());
    }

    public function getGroups(){
        return view('admin.v1.categories.group', $this->categoryService->getGroup());
    }

    public function get($category_id)
    {
        return response()->json([
            'message' => 'success',
            'data' => $this->categoryService->edit($category_id)
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        return back()->with('success', $this->categoryService->save($request));
    }

    public function destroy($category_id)
    {
        $this->categoryService->delete($category_id);
        return response()->json([
            'message' => 'success',
            'data' => [],
        ]);
    }

    public function updatePosition(Request $request){
        $this->categoryService->updatePosition($request);
        return response([
            'message' => 'success',
            'data' => []
        ]);
    }
}
