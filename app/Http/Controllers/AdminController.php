<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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
}
