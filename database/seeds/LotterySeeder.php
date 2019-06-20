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
        Lottery::create(['name' => 'New York AM','abbrev' => 'NY AM']);
        Lottery::create(['name' => 'Florida AM','abbrev' => 'FL AM']);
        Lottery::create(['name' => 'Gana Mas','abbrev' => 'GanaMas']);
        Lottery::create(['name' => 'Georgia AM','abbrev' => 'GA AM']);
        Lottery::create(['name' => 'FL Pick2 AM','abbrev' => 'P2AM']);
        Lottery::create(['name' => 'New York PM','abbrev' => 'NY PM']);
        Lottery::create(['name' => 'Loteria Nacional','abbrev' => 'LN']);
        Lottery::create(['name' => 'Florida PM','abbrev' => 'FL PM']);
        Lottery::create(['name' => 'Georgia Evening PM','abbrev' => 'GA PM']);
        Lottery::create(['name' => 'FL Pick2 PM','abbrev' => 'P2PM']);


        // Lottery::create(['name' => 'New York AM', 'abbrev' => 'NY AM']);
        // Lottery::create(['name' => 'Florida AM', 'abbrev' => 'FL AM']);
        // Lottery::create(['name' => 'Gana Mas', 'abbrev' => 'GA PM']);
        // Lottery::create(['name' => 'Georgia AM', 'abbrev' => 'GAAM']);
        // Lottery::create(['name' => 'FL Pick2 AM', 'abbrev' => 'NY PM']);
        // Lottery::create(['name' => 'New York PM', 'abbrev' => 'SP PM']);
        // Lottery::create(['name' => 'Loteria Nacional', 'abbrev' => 'NJ PM']);
        // Lottery::create(['name' => 'Florida PM', 'abbrev' => 'LN PM']);
        // Lottery::create(['name' => 'Georgia Evening PM', 'abbrev' => 'P2PM']);
        // Lottery::create(['name' => 'FL Pick2 PM', 'abbrev' => 'FL PM']);
    }
}
