<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'lottery_id','game_id','price','date',
    ];

    public function lottery()
    {
        return $this->belongsTo('App\Models\Lottery');
    }

    public function game()
    {
        return $this->belongsTo('App\Models\Game');
    }
}
