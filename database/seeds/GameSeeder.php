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
        Game::create(['name' => 'Directo']);
        Game::create(['name' => 'Pale']);
        Game::create(['name' => 'Tripleta']);
        Game::create(['name' => 'Cash 3 Straight']);
        Game::create(['name' => 'Cash 3 Box']);
        Game::create(['name' => '4 Straight']);
        Game::create(['name' => '4 Box']);
        Game::create(['name' => 'Super Pale']);
    }
}
