<?php

use Illuminate\Database\Seeder;
use App\Models\Game;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Directo']);
        Role::create(['name' => 'Pale']);
        Role::create(['name' => 'Tripleta']);
        Role::create(['name' => 'Cash 3 Straight']);
        Role::create(['name' => 'Cash 3 Box']);
        Role::create(['name' => '4 Straight']);
        Role::create(['name' => '4 Box']);
        Role::create(['name' => 'Super Pale']);
    }
}
