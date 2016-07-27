<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Storage;
use Auth;
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
    protected $redirectTo = '/albums';
    protected $username = 'username';

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
            'answer' => bcrypt($data['answer']),
            'password' => bcrypt($data['password']),
            'active' => 1, 
        ]);
    }
}
