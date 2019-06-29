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
        Lottery::create(['name' => 'New York AM','abbrev' => 'NY AM','limit_time' => '12:20:00']);
        Lottery::create(['name' => 'Florida AM','abbrev' => 'FL AM','limit_time' => '13:25:00']);
        Lottery::create(['name' => 'New Jersey AM','abbrev' => 'NJ AM','limit_time' => '12:00:00']);
        Lottery::create(['name' => 'Georgia AM','abbrev' => 'GA AM','limit_time' => '12:24:00']);
        Lottery::create(['name' => 'FL Pick2 AM','abbrev' => 'P2AM','limit_time' => '13:25:00']);
        Lottery::create(['name' => 'New York PM','abbrev' => 'NY PM','limit_time' => '19:10:00']);
        Lottery::create(['name' => 'New Jersey PM','abbrev' => 'NJ PM','limit_time' => '20:00:00']);
        Lottery::create(['name' => 'Florida PM','abbrev' => 'FL PM','limit_time' => '20:30:00']);
        Lottery::create(['name' => 'Georgia Evening PM','abbrev' => 'GA PM','limit_time' => '19:00:00']);
        Lottery::create(['name' => 'FL Pick2 PM','abbrev' => 'P2PM','limit_time' => '20:20:00']);

    }
}
