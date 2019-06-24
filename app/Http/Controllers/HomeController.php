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
use Carbon\Carbon;

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
        $balance = Auth::user()->balance;
        $lottery = Lottery::get();
        if(WinNumber::get()->isNotEmpty()){
            $date = WinNumber::latest('date')->first()->date;
            $date_array = WinNumber::distinct()->orderBy('date','desc')->limit(3)->pluck('date')->toArray();
            $win_data = WinNumber::whereDate('date', $date)->orderBy('lottery_id')->get()->load('lottery');
            if(Ticket::get()->isNotEmpty()){
                $tickets = Ticket::where('user_id',$user_id)->get();
                return view('home',compact('win_data','date','lottery','tickets','balance'));
            }else{
                return view('home',compact('win_data','date','lottery','balance'));
            }            
        }else{
            if(Ticket::find($user_id)->get()->isNotEmpty()){
                $tickets = Ticket::find($user_id)->get();
                return view('home',compact('lottery','tickets','balance'));
            }else{
                return view('home',compact('lottery','balance'));
            }
        }
    }

    public function check_avail(Request $request)
    {
        $user_id = Auth::user()->id;
        $lottery_id = $request->get('lottery_id');
        $game_id = $request->get('game_id');
        $play = $request->get('play');
        // $date = date('Y-m-d');
        $date = date('2019-6-23');
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
        $total = 0;
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->name;
        $ticket = $request->all();
        if(!empty($ticket)){
            $unique_id = hexdec(uniqid());
            $data = Ticket::create([
                'user_id' => $user_id,
                'bar_code' => $unique_id,
            ]);
            $id = $data->id;
            $date = $data->created_at->format('m/d/Y h:i A');
            foreach ($ticket as $value) {
                $detail = explode(',',$value);
                $ticket_id = $id;
                $lottery_id = $detail[0];
                $game_id = $detail[1];
                $number = $detail[2];
                $amount = $detail[3];
                $total += (int)$amount;
                TicketDetail::create([
                    'ticket_id' => $ticket_id,
                    'game_id' => $game_id,
                    'lottery_id' => $lottery_id,
                    'number' => $number,
                    'amount' => $amount,
                ]);
            }
            $balance = Auth::user()->balance;
            $balance = $total + (int)$balance;
            User::find($user_id)->update(['balance' => $balance]);
            return response()->json([
                'ticket_id' => $id,
                'date' => $date,
                'balance' => $balance,
                'name' => $user_name,
                'bar_code' => $unique_id,
            ]);
        }
        return 'fail';
        
    }

    public function delete_ticket(Request $request)
    {
        $ticket_id = $request->get('ticket_id');
        $ticket_details = TicketDetail::where('ticket_id',$ticket_id)->get();
        $date = date('Y-m-d h:m:s');
        $results = array();
        foreach ($ticket_details as $ticket) {
            array_push($results,$ticket->lottery_id.','.$ticket->game_id.','.$ticket->number.','.$ticket->amount);
        }
        $amount = Ticket::find($ticket_id)->details()->sum('amount');
        if($request->get('copy') == 1){
            array_push($results,$amount);
            array_push($results,$date);
            return $results;
        }else{
            $user_id = Auth::user()->id;
            $balance = Auth::user()->balance;
            $balance = (int)$balance - $amount;
            User::find($user_id)->update(['balance' => $balance]);
            Ticket::where('id', $ticket_id)->delete();
            TicketDetail::where('ticket_id', $ticket_id)->delete();
            array_push($results,$balance);
            array_push($results,$date);
            return $results;
        }
        
    }
}
