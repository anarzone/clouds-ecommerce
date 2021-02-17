<?php

namespace App\Http\Controllers\Admin\V1\Campaigns;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCampaignRequest;
use App\Http\Resources\Api\V1\Category;
use App\Http\Resources\Api\V1\Product;
use App\Models\Images\Image;
use App\Services\CampaignService;
use App\Services\ImageService;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    private $campaignService, $imageService;

    public function __construct(CampaignService $campaignService, ImageService $imageService)
    {
        $this->middleware('auth');
        $this->campaignService = $campaignService;
        $this->imageService = $imageService;
    }

    public function index(){
        return view('admin.v1.campaigns.index', $this->campaignService->index());
    }

    public function create(){
        return view('admin.v1.campaigns.store', $this->campaignService->create());
    }

    public function store(StoreCampaignRequest $request)
    {
        $this->campaignService->save($request);
        return redirect()->route('campaigns.index')->with('success');
    }

    public function getParentCategoriesByTypes(Request $request){
        return response([
            'message' => 'success',
            'data' => $this->campaignService->getParentCategoriesByTypes($request)
        ]);
    }

    public function filterProducts(Request $request){
        return response([
            'message' => 'success',
            'data' => Product::collection($this->campaignService->filterProducts($request))
        ]);
    }

    public function edit($campaignId){
        return view('admin.v1.campaigns.store', $this->campaignService->edit($campaignId));
    }

    public function delete($product_id){
        $this->campaignService->delete($product_id);
        return response()->json([
            'message' => 'success',
            'data' => [],
        ]);
    }
}
