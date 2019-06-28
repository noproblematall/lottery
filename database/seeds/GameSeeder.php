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
        Game::create(['name' => 'Directo','price' => '65,15,10']);
        Game::create(['name' => 'Pale','price' => '800']);
        Game::create(['name' => 'Tripleta','price' => '10000']);
        Game::create(['name' => 'Cash 3 Straight','price' => '700']);
        Game::create(['name' => 'Cash 3 Box','price' => '700']);
        Game::create(['name' => 'Play 4 Straight','price' => '4000']);
        Game::create(['name' => 'Play 4 Box','price' => '4000']);
        Game::create(['name' => 'Pick 5 Straight','price' => '30000']);
        Game::create(['name' => 'Pick 5 Box','price' => '30000']);
        Game::create(['name' => 'Super Pale','price' => '2000']);
    }
}
