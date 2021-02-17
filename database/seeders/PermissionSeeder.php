<?php

namespace Database\Seeders;

use App\Models\Stuff\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Permission::truncate();
        User::truncate();
        Admin::truncate();
        Schema::enableForeignKeyConstraints();

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();


        Permission::create(['name' => 'edit']);
        Permission::create(['name' => 'create']);
        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'read']);

        $superAdminRole = Role::create(['name' => 'super-admin']);
        $editorRole = Role::create(['name' => 'editor']);
        $moderatorRole = Role::create(['name' => 'moderator']);

        $superAdminRole->givePermissionTo('edit');
        $superAdminRole->givePermissionTo('create');
        $superAdminRole->givePermissionTo('read');
        $superAdminRole->givePermissionTo('delete');

        $editorRole->givePermissionTo('edit');
        $editorRole->givePermissionTo('read');

        $moderatorRole->givePermissionTo('read');


        $superAdmin = Admin::create([
            'name' => 'Admin',
            'phone' => '9991313134',
            'user_id' => User::create([
                'email' => 'admin@admin.com',
                'password' => Hash::make(1234),
            ])->id
        ]);

        $superAdmin->assignRole('super-admin');

        $editor = Admin::create([
            'name' => 'Editor',
            'phone' => '9991313134',
            'user_id' => User::create([
                'email' => 'editor@admin.com',
                'password' => Hash::make(1234),
            ])->id
        ]);

        $editor->assignRole('editor');

        $moderator = Admin::create([
            'name' => 'Moderator',
            'phone' => '9991313134',
            'user_id' => User::create([
                'email' => 'moderator@admin.com',
                'password' => Hash::make(1234),
            ])->id
        ]);

        $moderator->assignRole('moderator');

    }
}
