<?php

use Illuminate\Database\Seeder;
use App\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Permission::create([
            'name' => 'view data' // id 31
        ]);
        App\Permission::create([
            'name' => 'create data' // id 32
        ]);
        App\Permission::create([
            'name' => 'edit data' // id 33
        ]);
        App\Permission::create([
            'name' => 'update data' // id 34
        ]);
        App\Permission::create([
            'name' => 'delete data' // id 35
        ]);

        $admin = App\Role::where('name', 'admin')->first();
        $admin->permissions()->attach([1, 2, 3, 4, 5]);

        $staff = App\Role::where('name', 'spv')->first();
        $staff->permissions()->attach([1, 2, 3, 4, 5]);

        $ceo = App\Role::where('name', 'csr')->first();
        $ceo->permissions()->attach([1, 2, 3, 4, 5]);
    }
}
