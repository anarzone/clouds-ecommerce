<?php

namespace App\Http\Controllers\Admin\V1\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


}
