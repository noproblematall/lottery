<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    protected $fillable = [
        'ticket_id','game_id','lottery_id','number','amount',
    ];

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }

    public function game()
    {
        return $this->belongsTo('App\Models\Game');
    }

    public function lottery()
    {
        return $this->belongsTo('App\Models\Lottery');
    }
}
