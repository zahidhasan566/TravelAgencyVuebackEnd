<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Customer']);
        // Admin
        $user = User::where('id', 1)->first();
        $role = Role::where('name', 'Admin')->first();

        $user->assignRole($role);

    }
}
