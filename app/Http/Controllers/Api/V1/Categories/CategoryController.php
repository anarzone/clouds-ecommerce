<?php

namespace App\Http\Controllers\Api\V1\Categories;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\AgeType;
use App\Http\Resources\Api\V1\Campaign;
use App\Http\Resources\Api\V1\Category;
use App\Http\Resources\Api\V1\CategoryCollection;
use App\Http\Resources\Api\V1\GenderType;
use App\Services\CampaignService;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private $categoryService, $campaignService;

    public function __construct(CategoryService $categoryService, CampaignService $campaignService)
    {
        $this->middleware('auth:api', ['except' => [
                                                    'getGenderTypes',
                                                    'getHome',
                                                    'getAgeTypes',
                                                    'getByTypes',
                                                    'index',
                                                    'getSubCategories',
                                                ]
        ]);
        $this->categoryService = $categoryService;
        $this->campaignService = $campaignService;
    }

    public function index(){
        return response()->json([
            'message' => 'Retrieved home page',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' =>  [
                'categories' => Category::collection($this->categoryService->getAll()),
                'campaigns' => Campaign::collection($this->campaignService->activeCampaigns()),
            ]
        ]);
    }

    public function getGenderTypes(){
        return response()->json([
            'message' => 'Retrieved gender types',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            "data" => GenderType::collection($this->categoryService->getGenderTypes()),
        ]);
    }

    public function getAgeTypes(){
        return response()->json([
            'message' => 'Retrieved age types',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            "data" => AgeType::collection($this->categoryService->getAgeTypes()),
        ]);
    }

    public function getByTypes(Request $request){
        $validator = Validator::make($request->all(), [
            'gender_type' => 'required|numeric',
            'age_type' => 'required|numeric',
        ]);

        if ($validator->fails()){
            return response([
                'message' => 'The given data is invalid',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $validator->getMessageBag(),
            ]);
        }

        return response()->json([
            'message' => 'Retrieved categories by gender and age types',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            "data" => Category::collection($this->categoryService->getByTypes($request)),
        ]);
    }

    public function getSubCategories($categoryId){
        return response()->json([
            'message' => 'Retrieved subcategories',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            "data" => Category::collection($this->categoryService->getSubCategories($categoryId)),
        ]);
    }
}
