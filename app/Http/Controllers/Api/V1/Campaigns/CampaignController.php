<?php

namespace App\Http\Controllers\Api\V1\Campaigns;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ProductList;
use App\Services\CampaignService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CampaignController extends Controller
{
    private $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    public function getProductsById($id){
        $products = $this->campaignService->getProductsById($id);
        return response()->json([
            'message' => 'Retrieved campaign products',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' =>  $products ? ProductList::collection($products) : [],
        ]);
    }
}
