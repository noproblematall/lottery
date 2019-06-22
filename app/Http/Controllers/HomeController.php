<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Lottery;
use App\Models\WinNumber;
use App\Models\Game;
use App\Models\Price;
use App\Models\TicketDetail;
use App\Models\Ticket;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','super','status']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $lottery = Lottery::get();
        if(WinNumber::get()->isNotEmpty()){
            $date = WinNumber::latest('date')->first()->date;
            $date_array = WinNumber::distinct()->orderBy('date','desc')->limit(3)->pluck('date')->toArray();
            $win_data = WinNumber::whereDate('date', $date)->orderBy('lottery_id')->get()->load('lottery');
            if(Ticket::get()->isNotEmpty()){
                $tickets = Ticket::find($user_id)->get();
                return view('home',compact('win_data','date','lottery','tickets'));
            }else{
                return view('home',compact('win_data','date','lottery'));
            }            
        }else{
            if(Ticket::find($user_id)->get()->isNotEmpty()){
                $tickets = Ticket::find($user_id)->get();
                return view('home',compact('lottery','tickets'));
            }else{
                return view('home',compact('lottery'));
            }
        }
    }

    public function check_avail(Request $request)
    {
        $user_id = Auth::user()->id;
        $lottery_id = $request->get('lottery_id');
        $game_id = $request->get('game_id');
        $play = $request->get('play');
        $date = date();
        if(Price::where([['date',$date],['lottery_id',$lottery_id],['game_id',$game_id]])->get()->isEmpty()){
            return 'fail';
        }
        $price = Price::where([['date',$date],['lottery_id',$lottery_id],['game_id',$game_id]])->first()->price;
        if($price != NULL){
            $tickets = Ticket::whereDate('created_at', $date)->where('user_id',$user_id)->get();
            
            if($tickets->isnotEmpty()){
                foreach ($tickets as $ticket) {
                    $ticket_details = TicketDetail::where([['ticket_id',$ticket->id],['lottery_id',$lottery_id]])->get();
                    foreach ($ticket_details as $detail) {
                        if($detail->number == $play){
                            $avail = $price - ($detail->amount);
                            return $avail;
                        }
                    }
                }
            }else{
                return $price;
            }
        }else{
            $errors = [
                'error' => 'error',
                'content' => 'This lottery don\'t allow the play.'
            ];
            return response()->json($errors);
        }
    }

    public function create_ticket(Request $request)
    {
        $user_id = Auth::user()->id;
        $ticket = $request->all();
        if(!empty($ticket)){
            $id = DB::table('tickets')->insertGetId(
                [
                    'user_id' => $user_id,
                ]
            );
            foreach ($ticket as $value) {
                $detail = explode(',',$value);
                $ticket_id = $id;
                $lottery_id = $detail[0];
                $game_id = $detail[1];
                $number = $detail[2];
                $amount = $detail[3];
                TicketDetail::create([
                    'ticket_id' => $ticket_id,
                    'game_id' => $game_id,
                    'lottery_id' => $lottery_id,
                    'number' => $number,
                    'amount' => $amount,
                ]);
            }
            $date = date('Y-m-d h:m:s');
            return response()->json([
                'ticket_id' => $id,
                'date' => $date
            ]);
        }
        return 'fail';
        
    }
}
