<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    protected $fillable = [
        'name',
    ];

    public function win_numbers()
    {
        return $this->hasMany('App\Models\WinNumber');
    }

    public function details()
    {
        return $this->hasMany('App\Models\TicketDetail');
    }

    public function prices()
    {
        return $this->hasMany('App\Models\Price');
    }
}
