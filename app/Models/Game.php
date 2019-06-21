<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name',
    ];

    public function details()
    {
        return $this->hasMany('App\Models\TicketDetail');
    }

    public function prices()
    {
        return $this->hasMany('App\Models\Price');
    }
}
