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

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','user']);
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function user()
    {
        $user = new User();
        $users = $user->where('role_id', '!=',1)->get();
        return view('admin.user', compact('users'));
    }

    public function add_user(Request $request)
    {
        $name = $request->get('name');
        $user = new User();
        $exist = $user->where('name',$name)->first();
        if($exist !== null){
            return 0;
        }else{
            $photo = 'images/avatars/1.png';
            $username = $request->get('username');
            $password = $request->get('password');
            $email = $request->get('email');
            User::create([
                'name' => $name,
                'user_name' => $username,
                'email' => $email,
                'photo' => $photo,
                'password' => Hash::make($password)
            ]);
            return 1;
        }        
    }

    public function edit_balance(Request $request)
    {
        $balance = $request->get('balance');
        $id = $request->get('id');
        User::find($id)->update([
            'balance' => $balance
        ]);
        return 1;
    }

    public function user_edit($id)
    {
        $user = User::find($id);
        return view('admin.user_edit',compact('user'));
    }

    public function user_delete($id)
    {
        DB::table('users')->where('id',$id)->delete();
        return back();
        
    }

    public function user_save(Request $request)
    {
        $name = $request->get('name');
        $id = $request->get('id');
        $count = User::where('name',$name)->count();
        if($count > 0){
            $existUser = User::where('name',$name)->select('id')->first();
            if($existUser->id != $id){
                $errors = ['name' => 'The User ID has already been taken.'];
                return back()->withErrors($errors);
            }
        }
        $username = $request->get('username');
        $balance = $request->get('balance');
        $email = $request->get('email');
        if($request->get('password') != null){
            $password = $request->get('password');
            DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $name,
                'user_name' => $username,
                'email' => $email,
                'balance' => $balance,
                'password' => Hash::make($password)
            ]);
            return back()->with('success','The user was successfully updated.');
        }else{
            DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $name,
                'user_name' => $username,
                'email' => $email,
                'balance' => $balance,
            ]);
            return back()->with('success','The user was successfully updated.');
        }
    }

    public function setting()
    {
        return view('admin.setting');
    }

    public function admin_setting(Request $request)
    {
        $id = Auth::user()->id;
        $user_name = Auth::user()->name;
        $cur_photo = Auth::user()->photo;
        $username = $request->get('username');
        $set_email = $request->get('email');
        $cur_password = $request->get('cur_password');
        $new_password = $request->get('password');

        $name = $request->get('name');
        $count = User::where('name',$name)->count();
        if($count > 0){
            $existUser = User::where('name',$name)->select('id')->first();
            if($existUser->id != $id){
                $errors = ['name' => 'The User ID has already been taken.'];
                return back()->withErrors($errors);
            }
        }
        
        if($cur_password){
            if(!Hash::check($cur_password, Auth::user()->password)){
                $errors = ['cur_password' => 'The password is incorrect.'];
                return back()->withErrors($errors);
            }else{
                if($request->hasfile('photo')){
                    $fileName = time() . '.' . request()->photo->getClientOriginalExtension();
                    request()->photo->move(public_path('images/avatars'),$fileName);
                    // $request->photo->storeAs('public/profile',$fileName);
                    $photo = 'images/avatars/' . $fileName;
                }else{
                    $photo = $cur_photo;
                }
                DB::table('users')
                ->where('id', $id)
                ->update([
                    'name' => $name,
                    'user_name' => $username,
                    'email' => $set_email,
                    'password' => Hash::make($new_password),
                    'photo' => $photo,
                ]);
                
                return back()->with('success','The password was successfully changed.');
            }
        }else{
            if($request->hasfile('photo')){
                $fileName = time() . '.' . request()->photo->getClientOriginalExtension();
                request()->photo->move(public_path('images/avatars'),$fileName);
                // $request->photo->storeAs('public/profile',$fileName);
                $photo = 'images/avatars/' . $fileName;
            }else{
                $photo = $cur_photo;
            }
            DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $name,
                'user_name' => $username,
                'email' => $set_email,
                'photo' => $photo,
            ]);
            return back();
        }
    }

    public function user_block(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');
        User::find($id)->update([
            'status' => $status,
        ]);
    }

    public function win_number()
    {
        $lottery = Lottery::get();
        if(WinNumber::get()->isNotEmpty()){
            $date = WinNumber::latest('date')->first()->date;
            $date_array = WinNumber::distinct()->orderBy('date','desc')->limit(3)->pluck('date')->toArray();
            $win_data = WinNumber::whereDate('date', $date)->orderBy('lottery_id')->get();
            return view('admin.winnumber',compact('win_data','date_array','lottery'));
        }else{
            return view('admin.winnumber',compact('lottery'));
        }
        
    }

    public function add_win(Request $request)
    {
        $lottery_id = $request->get('lottery_id');
        $date = $request->get('date');
        $value = $request->get('value');
        $i = $request->get('i');
        $length = $request->get('length');
        $exist = WinNumber::where([['date',$date],['lottery_id',$lottery_id]])->count();
        if($exist > 0){
            WinNumber::where([['date',$date],['lottery_id',$lottery_id]])->update([
                'value' => $value,
            ]);
            if($i == $length-1){
                return 0;
            }
        }else{
            WinNumber::create([
                'date' => $date,
                'value' => $value,
                'lottery_id' => $lottery_id,
            ]);
            $win_number = explode(",", $value);
            $tickets = Ticket::whereDate('created_at', $date)->get();
            if($tickets->isNotEmpty()){
                foreach ($tickets as $ticket) {
                    foreach ($ticket->details as $detail) {
                        if($detail->lottery_id == $lottery_id){
                            $detail_number = preg_replace('/[^0-9]/', '', $detail->number);
                            if(in_array($detail_number, $win_number)){
                                $detail->is_win = 1;
                                foreach ($win_number as $key => $value) {
                                    if($value == $detail_number){
                                        $key_value = $key;
                                    }
                                }
                                $detail->prize = $this->prize_caculate($detail->game_id,$key_value, $detail->amount,$detail->lottery_id);
                                $detail->save();
                                if($ticket->is_pending == 0){
                                    $ticket->is_pending = 1;
                                    $ticket->save();
                                }
                            }
                        }
                    }
                }
            }
            
            if($i == $length-1){
                return 1;
            }
        }
    }

    public function prize_caculate($game_id, $key_value, $amount, $lottery_id)
    {
        $lottery_name = Lottery::find($lottery_id)->name;
        $lottery_abbrev = Lottery::find($lottery_id)->abbrev;
        if($lottery_name == 'FL Pick2 AM' || $lottery_name == 'FL Pick2 PM' || $lottery_abbrev == 'P2AM' || $lottery_abbrev == 'P2PM'){
            if($game_id == 1){
                
                return (int)$amount * 80;
            }else{
                return 0;
            }
        }
        $game_price = Game::find($game_id)->price;
        if($game_id == 1){
            $game_price = explode(",",$game_price);
            return (int)$amount * (int)$game_price[$key_value];
        }else{
            return (int)$amount * (int)$game_price;
        }
        
    }

    public function win_search(Request $request)
    {
        $date = $request->get('date');
        $date_array = WinNumber::distinct()->orderBy('date','desc')->limit(3)->pluck('date')->toArray();
        $win_data = WinNumber::whereDate('date', $date)->orderBy('lottery_id')->get()->load('lottery');
        return view('admin.winnumber',compact('win_data','date_array','date'));
    }

    public function avail_amount()
    {
        $game = Game::get();
        $lottery = Lottery::get();
        if(!Price::get()->isEmpty()){
            $date = Price::latest('date')->first()->date;
            $price_data = Price::whereDate('date', $date)->orderBy('lottery_id','asc')->orderBy('game_id','asc')->get();
            return view('admin.avail_amount',compact('price_data','game','lottery','date'));
        }
        return view('admin.avail_amount',compact('game','lottery'));
    }

    public function add_amount(Request $request)
    {
        $lottery_id = $request->get('lottery_id');
        $game_id = $request->get('game_id');
        $date = $request->get('date');
        $price = $request->get('price');
        $exist = Price::where([['date',$date],['lottery_id',$lottery_id],['game_id',$game_id]])->count();
        if($exist > 0){
            Price::where([['date',$date],['lottery_id',$lottery_id],['game_id',$game_id]])->update([
                'price' => $price
            ]);
        }else{
            Price::create([
                'lottery_id' => $lottery_id,
                'game_id' => $game_id,
                'price' => $price,
                'date' => $date,
            ]);
        }
        
    }
}
