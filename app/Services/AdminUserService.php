<?php


namespace App\Services;


use App\Repositories\AdminUserRepository;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserService
{
    private $adminUserRepository, $userService;

    public function __construct(AdminUserRepository $adminUserRepository,
                                UserService $userService
    )
    {
        $this->adminUserRepository = $adminUserRepository;
        $this->userService = $userService;
    }

    public function index(){
        return [
            'adminUsers' => $this->adminUserRepository->all(),
        ];
    }

    public function create(){
        return [
            'roles' => Role::all(),
        ];
    }

    public function edit($adminUserId){
        return [
            'adminUser' => $this->adminUserRepository->find($adminUserId),
            'roles' => Role::all(),
        ];
    }

    public function save($request){
        return $this->adminUserRepository->save($request->get('user_id'), [
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'user_id' => $this->userService->save([
                'id' => $request->get('user_id'),
                'email' => $request->email,
                'password' => Hash::make( $request->password),
            ])->id
        ])->syncRoles($request->role_id);
    }

    public function delete($id){
        $this->adminUserRepository->delete($id);
    }
}
