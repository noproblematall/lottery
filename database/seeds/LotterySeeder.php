<?php

use Illuminate\Database\Seeder;
use App\Models\Lottery;
class LotterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lottery::create(['name' => 'NYA1']);
        Lottery::create(['name' => 'NY AM']);
        Lottery::create(['name' => 'SP AM']);
        Lottery::create(['name' => 'GA AM']);
        Lottery::create(['name' => 'NJ AM']);
        Lottery::create(['name' => 'P2AM']);
        Lottery::create(['name' => 'FL AM']);
        Lottery::create(['name' => 'FAFO']);
    }
}
