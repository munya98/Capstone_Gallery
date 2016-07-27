<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\User;
use App\Image;
use Storage;


class UserController extends Controller
{
    //
    public function index($user){
    	$currentUser = User::where('username', $user)->first();
    	$images = Image::where('user_id', '=', $currentUser->id)->where('permission', 'public')->simplePaginate(9);
    	return view('vendor.user')->with('user', $currentUser)->with('images', $images);
    }
     //Get Image from Storage
    public function showAvatar($file){
    	//Storage::setVisibility('avatars/default.jpg', 'private');
    	$f = Storage::get('avatars/'. $file);
		return (new Response($f, 200))
                  ->header('Content-Type', 'image/jpeg');
    }
}
