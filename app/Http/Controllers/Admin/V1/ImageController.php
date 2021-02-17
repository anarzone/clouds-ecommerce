<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Models\Images\Image;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function get($image_id){
        $this->imageService->get($image_id);
    }

    public function upload(Request $request){
        return response()->json([
            'message' => 'success',
            'data' => $this->imageService->upload($request->file, [
                                                        'dir' => $request->path,
                                                        'type' => Image::PRODUCT_TYPE,
                                                        'id' => null
                                                    ])
        ]);
    }

    public function remove(Request $request){
        return response()->json([
            'message' => 'success',
            'data' => $this->imageService->remove($request->imageName)
        ]);
    }
}
