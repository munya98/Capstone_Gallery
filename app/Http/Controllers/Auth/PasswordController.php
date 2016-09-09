<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Validator;
use App\User;
use Hash;
use App\Http\Requests;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function reset(){
        return view('auth\passwords.username');
    }
    public function validate_username(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users,username'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        return redirect('/user/password/reset/' . $request->input('username'));
    }
    public function confirm_answer($username){
        $user = User::where('username', $username)->first();

        return view('auth\passwords.reset')->with('user', $user);
    }
    public function validate_answer(Request $request){
        $user = User::where('username', $request->input('username'))->first();

        if($request->input('answer') == $user->answer){
            return view('auth\passwords.password')->with('user', $user->username);
        }
        session()->flash('status', 'The answer you provided does not match');
        return redirect()->back();
    }
    public function update_password(Request $request){
        $user = User::where('username', $request->input('username'))->first();

        $validator = Validator::make($request->all(),[
            'password' => 'required|confirmed' 
        ]);

        if($validator->fails()){
            return view('auth\passwords.password')->with('user', $user->username)->withErrors($validator);
        }

        $user->password = bcrypt($request->input('password'));
        $user->save();
        session()->flash('password-update', 'Your password was successfully updated');
        return redirect('/login');
    }
}
