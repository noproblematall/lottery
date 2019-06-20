<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WinNumber extends Model
{
    protected $fillable = [
        'date','lottery_id','value',
    ];

    public function lottery()
    {
        return $this->belongsTo('App\Models\Lottery');
    }
}
