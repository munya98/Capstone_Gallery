<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Storage;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    //protected $username = 'username';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
    * Manually login a user
    *
    */
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        else{
            $user = User::where('username', $request->input('username'))->first();
            if (Hash::check($request->input('password'), $user->password)) {
                if (Auth::attempt(['username' => $user->username, 'password' => $request->input('password'), 'active' => 1])) {
                    return redirect()->back();
                }else {
                    session()->flash('account-status', 'Your account is suspended');
                    return redirect('/login');
                }
            }
            session()->flash('status', 'Username or password is incorrect');
            return redirect()->back();
        }
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:25',
            'username' => 'required|min:4|max:25|unique:users|alpha_num',
            'question' => 'required|min:10',
            'answer' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     * Create folders
     */
    protected function create(array $data)
    {
        
        Storage::makeDirectory('users/albums/' . $data['username'] . '/public');
        Storage::makeDirectory('users/albums/' . $data['username'] . '/private');
       
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'question' => $data['question'],
            'answer' => $data['answer'],
            'password' => bcrypt($data['password']),
            'active' => 1, 
        ]);
    }
}
