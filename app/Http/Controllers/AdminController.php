<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Image;
use App\Album;
use DB;
use App\Http\Requests;

class AdminController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
		$this->middleware('role:Admin');
	}
    public function index(){
    	$users = User::all();
    	$totalUsers = User::all()->count();
    	$totalImages = Image::all()->count();
    	$totalAlbums = Album::all()->count();
    	$latestImage = DB::table('images')->OrderBy('created_at','desc')->take(1)->first();
    	$recentImages = DB::table('images')->where('image_id', '<>', $latestImage->image_id)
    									   ->OrderBy('created_at', 'desc')
    									   ->take(10)->get();
    	$recentUsers = DB::table('users')->OrderBy('created_at', 'desc')->take(5)->get();
    	return view('admin.dashboard')->with('users', $users)
    								  ->with('totalUsers', $totalUsers)
    								  ->with('totalImages', $totalImages)
    								  ->with('totalAlbums', $totalAlbums)
    								  ->with('latestImage', $latestImage)
    								  ->with('recentImages', $recentImages)
    								  ->with('recentUsers', $recentUsers);
    }
    public function users(){
        $users = DB::table('users')->paginate(25);
        return view('admin.users')->with('users', $users);
    }
    public function view_user(User $user){
        return $user;
    }
    public function albums(){
        return view('admin.albums');
    }
    public function images(){
        $images = DB::table('images')->paginate(25);
        return view('admin.images')->with('images', $images);
    }
    public function view_image(Image $image){
        return $image;
    }
    public function reports(){
        return view('admin.reports');
    }

}
