<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\User;
use App\Image;
use App\Album;
use Storage;


class UserController extends Controller
{
     /**
    *   Fetch a user
    *   @param $user - Current user
    *   @return Images from current user
    */
    public function index($user){
    	$currentUser = User::where('username', $user)->first();
        if (empty($currentUser)) {
            abort(404);
        }
    	$images = Image::where('user_id', '=', $currentUser->id)->where('permission', 'public')->simplePaginate(30);
      $imageCount = Image::where('user_id', '=', $currentUser->id)->count();
      $albumCount = Album::where('user_id', '=', $currentUser->id)->count();
    	return view('images.user')->with('user', $currentUser)
                                  ->with('images', $images)
                                  ->with('img_count', $imageCount)
                                  ->with('album_count', $albumCount);
    }
    /**
    *   Fetch a user's avatar from storage
    *   @param $user - Current user
    *   @return User's avatar
    *   
    */
    public function showAvatar($file){
    	$f = Storage::get('avatars/'. $file);
		  return (new Response($f, 200))
                  ->header('Content-Type', 'image/jpeg');
    }
}
