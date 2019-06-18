<?php

use Illuminate\Database\Seeder;
use App\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'user_name' => 'Admin',
            'email' => 'admin@example.com',
            'role_id' => 1,
            'photo' => 'images/avatars/1.png',
            'password' => bcrypt('admin123456'),
            'status' => 1,
            'balance' => 0,
        ]);
    }
}
