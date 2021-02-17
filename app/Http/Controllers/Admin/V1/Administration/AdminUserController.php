<?php

namespace App\Http\Controllers\Admin\V1\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreAdminUserRequest;
use App\Services\AdminUserService;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    private $adminUserService;

    public function __construct(AdminUserService $adminUserService)
    {
        $this->middleware('auth');
        $this->adminUserService = $adminUserService;
    }

    public function index(){
        return view('admin.v1.adminUsers.index', $this->adminUserService->index());
    }

    public function create(){
        return view('admin.v1.adminUsers.store', $this->adminUserService->create());
    }

    public function edit($adminUserId){
        return view('admin.v1.adminUsers.store', $this->adminUserService->edit($adminUserId));
    }

    public function delete($adminUserId){
        $this->adminUserService->delete($adminUserId);
        return response()->json([
            'message' => 'success',
            'data' => []
        ]);
    }

    public function store(StoreAdminUserRequest $request){
        $this->adminUserService->save($request);

        return redirect()->route('admins.index')->with('success', 'Yadda saxlanıldı');
    }
}
