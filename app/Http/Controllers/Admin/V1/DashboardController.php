<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('admin.v1.static.dashboard');
    }
}
