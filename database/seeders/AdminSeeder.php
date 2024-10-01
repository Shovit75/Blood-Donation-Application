<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'asdf',
            'email' => 'asdf@asdf.com',
            'password' => bcrypt('asdf1234'),
        ]);

        $permissions = [
            ['name' => 'auth_permission', 'guard_name' => 'web'], // Using 'web' guard name
            ['name' => 'donor_permission', 'guard_name' => 'web'], // Using 'web' guard name
        ];

        $roles = [
            ['name' => 'authenticated_user', 'guard_name' => 'web'], // Using 'web' guard name
            ['name' => 'donor', 'guard_name' => 'web'], // Using 'web' guard name
        ];

        foreach ($permissions as $p) {
            Permission::create($p);
        }

        foreach ($roles as $r) {
            Role::create($r);
        }

        // Assign permissions to roles
        $authUserRole = Role::where('name','authenticated_user')->first();
        if ($authUserRole) {
            $authUserRole->givePermissionTo('auth_permission');
        }

        $donorRole = Role::where('name','donor')->first();
        if ($donorRole) {
            $donorRole->givePermissionTo(['donor_permission', 'auth_permission']);
        }
    }
}
