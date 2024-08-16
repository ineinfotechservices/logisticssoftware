<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
      //  $this->middleware('auth');
    }
   
    public function showLoginForm() {


        return view('auth.login');
    }

    public function logincheck(Request $request) {
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $password = $request->password;
        $email = $request->email;
        $user_info = User::where('email',$email)->where('status',1)->first();
        if($user_info == null) {
            session()->flash('error', 'Your Email is not recognized.');
            return redirect('/login');
        }
        if(!isset($user_info->password)) {
            session()->flash('error', 'Invalid password.');
            return redirect('/login');
        }
        if($user_info->password == null) {
            session()->flash('error', 'Invalid password.');
            return redirect('/login');
        }
        if(Hash::check($password,$user_info->password)) { 
            Auth::login($user_info);
            \DB::table('user_logs')->insert([
                'user_id'=>$user_info->id,
            ]);
            session()->flash('success', 'You are successfully logged in');
            return redirect(route('users.dashboard'));
        }else{
            
            session()->flash('error', 'Invalid Credentials');
            return redirect('/login');
        }
    }
}
