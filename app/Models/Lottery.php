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
}
