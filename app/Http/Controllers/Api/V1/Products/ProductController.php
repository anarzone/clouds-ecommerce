<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Filter;
use App\Http\Resources\Api\V1\Product;
use App\Http\Resources\Api\V1\ProductList;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getBySubCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|numeric',
            'gender_type_id' => 'required|numeric',
            'age_type_id' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response([
                'message' => 'Not a correct type',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $validator->getMessageBag()
            ]);
        }

        return response()->json([
            'message' => 'Retrieved all products',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => ProductList::collection($this->productService->getBy($request))
        ]);
    }

    public function getByParentCategory($categoryId){
        return response([
            'message' => 'Retrieved single product',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => Product::collection($this->productService->getByParentCategory($categoryId))
        ]);
    }

    public function getSingle($product_id){
        return response()->json([
            'message' => 'Retrieved single product',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => [
                'product' => new Product($this->productService->getSingle($product_id)),
                'similar_products' => Product::collection($this->productService->getSimilar($product_id))
            ]
        ]);
    }

    public function sort($sortBy){
        $validated = Validator::make(['sortBy' => $sortBy], [
            'sortBy' => 'required|numeric'
        ]);

        if($validated->fails()){
            return response([
                'message' => 'Not a correct type',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'data' => []
            ]);
        }

        return response([
            'message' => 'Retrieved sorted products',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => Product::collection($this->productService->sort($sortBy)),
        ]);
    }

    public function  filter(Request $request){
        $validator = Validator::make($request->all(),[
            'category_id' => 'nullable|numeric',
            'productTypeId' => 'nullable|numeric',
            'brandId' => 'nullable|numeric',
            'color' => 'nullable|string',
            'size' => 'nullable|string',
            'priceMin' => 'nullable|numeric',
            'priceMax' => 'nullable|numeric',
        ]);

        if($validator->fails()){
            return response([
                'message' => 'Wrong value',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $validator->getMessageBag()
            ]);
        }

        return response()->json([
            'message' => 'Retrieved filtered products',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => Product::collection($this->productService->filter($request)),
        ]);
    }

    public function getCategories(){
        return response([
            "message" => "Categories with count",
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            "data" => Filter::collection($this->productService->getCategories())
        ]);
    }

    public function getProductTypes(){
        return response([
            "message" => "Product types with count",
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            "data" => $this->productService->getProductTypes()

        ]);
    }

    public function getColors(){
        return response([
            "message" => "Product colors with count",
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            "data" =>  $this->productService->getColors()

        ]);
    }

    public function getSizes(){
        return response([
            "message" => "Product sizes with count",
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            "data" => $this->productService->getSizes()
        ]);
    }

    public function search(Request $request){
        $validator = Validator::make($request->all(), [
            'term' => 'required'
        ]);

        if($validator->fails()){
            return response([
                'message' => 'Invalid credentials',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $validator->getMessageBag()
            ]);
        }

        return response([
            'message' => 'Retrieved search results',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => Product::collection($this->productService->search($request->term))
        ]);

    }
}
