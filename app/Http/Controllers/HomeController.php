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
        $date = date('Y-m-d');
        // $date = date('2019-6-23');
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
        $user_name = Auth::user()->name;
        $ticket_id = $request->get('ticket_id');
        $ticket_details = TicketDetail::where('ticket_id',$ticket_id)->get();
        $date = date('m/d/Y h:i A');
        $results = array();
        foreach ($ticket_details as $ticket) {
            array_push($results,$ticket->lottery_id.','.$ticket->game_id.','.$ticket->number.','.$ticket->amount);
        }
        $amount = Ticket::find($ticket_id)->details()->sum('amount');
        if($request->get('copy') == 1){
            array_push($results,$user_name);
            array_push($results,$ticket_id);
            array_push($results,$date);
            return $results;
        }else{
            $user_id = Auth::user()->id;
            $balance = Auth::user()->balance;
            $balance = (int)$balance - $amount;
            User::find($user_id)->update(['balance' => $balance]);
            $bar_code = Ticket::where('id',$ticket_id)->first()->bar_code;
            Ticket::where('id', $ticket_id)->delete();
            TicketDetail::where('ticket_id', $ticket_id)->delete();
            array_push($results,$bar_code);
            array_push($results,$user_name);
            array_push($results,$balance);
            array_push($results,$date);
            return $results;
        }
        
    }

    public function summary()
    {
        $sum_of_amount = 0;
        $win_tickets_id = array();
        $total = 0;
        $user_id = Auth::user()->id;
        $name = Auth::user()->name;
        $date = date('Y-m-d');
        $yesterday = date('Y-m-d',strtotime("-1 days"));
        $win_numbers = WinNumber::where('date',$yesterday)->orderBy('lottery_id')->get();
        $win_numbers_array = array();
        foreach ($win_numbers as $item) {
            $win_numbers_array[$item->lottery_id] = explode(",", $item->value);
        }
        // dd($win_numbers_array);
        $yesterday_tickets = Ticket::where('user_id',$user_id)->whereDate('created_at',$yesterday)->get();
        foreach ($yesterday_tickets as $ticket) {
            foreach ($ticket->details as $detail) {
                if(isset($win_numbers_array[$detail->lottery_id])){
                    $detail_number = preg_replace('/[^0-9]/', '', $detail->number);
                    if(in_array($detail_number, $win_numbers_array[$detail->lottery_id])){                        
                        $sum_of_amount += $detail->amount;
                        if(! in_array($detail->ticket_id, $win_tickets_id)){
                            array_push($win_tickets_id, $detail->ticket_id);
                        }
                    }
                }
            }
        }
        $win_tickets_number = count($win_tickets_id);
        $loser_tickets_number = $yesterday_tickets->count() - $win_tickets_number;
        $today_tickets = Ticket::where('user_id',$user_id)->whereDate('created_at',$date)->get();

        foreach ($today_tickets as $ticket) {
            $amount = TicketDetail::where('ticket_id',$ticket->id)->sum('amount');
            $total += $amount;
        }
        $today_balance = $total;
        $balance = Auth::user()->balance;
        $current_balance = $balance - $today_balance;
        return view('summary',compact('balance','current_balance','today_balance','name','sum_of_amount','win_tickets_number','loser_tickets_number'));
    }
}
