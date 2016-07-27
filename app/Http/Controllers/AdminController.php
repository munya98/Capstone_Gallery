<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;

class AdminController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
		$this->middleware('role:Admin');
	}
    public function index(){
    	$users = User::all();
    	return view('admin.dashboard')->with('users', $users);
    }
}
