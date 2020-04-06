<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name' => 'Dimas',
            'username' => 'niggatron',
            'password' => bcrypt('Dimas123'),
            'role_id' => 1
        ]);

        App\User::create([
            'name' => 'SPV Siantar',
            'username' => '16012956',
            'password' => bcrypt('Angsa9090'),
            'role_id' => 2
        ]);

        App\User::create([
            'name' => 'CSR Siantar',
            'username' => '16012957',
            'password' => bcrypt('Angsa9090'),
            'role_id' => 3
        ]);
    }
}
