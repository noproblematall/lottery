<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id','ticket_number','created_at','updated_at',
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }

    public function details()
    {
        return $this->hasMany('App\Models\TicketDetail');
    }
}
