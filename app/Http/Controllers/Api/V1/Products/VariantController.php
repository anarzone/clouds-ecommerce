<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Services\VariantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VariantController extends Controller
{
    private $variantService;

    public function __construct(VariantService $variantService)
    {
        $this->variantService = $variantService;
    }

    public function show(Request $request){
        $validated = Validator::make($request->all(),[
            'option1' => 'required|string',
            'option2' => 'required|string',
        ]);

        if($validated->fails()){
            return response([
                "message" => "error",
                "data" => [
                    $validated->getMessageBag()
                ]
            ]);
        }

        return response()->json([
            'message',
            'data' => $this->variantService->getByOptions($request),
        ]);
    }

}
