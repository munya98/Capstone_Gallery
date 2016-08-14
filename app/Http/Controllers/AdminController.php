<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Image;
use App\Album;
use DB;
use Validator;
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
    	$latestImage = DB::table('images')->OrderBy('created_at','desc')->first();
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
        $images = Image::where('user_id', $user->id)->count();
        $albums = Album::where('user_id', $user->id)->count();
        $likes= DB::table('likes')->where('user_id', $user->id)->count();
        return view('admin.singleuser')->with('user', $user)
                                       ->with('images', $images)
                                       ->with('albums', $albums)
                                       ->with('likes', $likes);
    }
    public function albums(){
        return view('admin.albums');
    }
    public function images(){
        $images = DB::table('images')->paginate(25);
        return view('admin.images')->with('images', $images);
    }
    public function view_image(Image $image){
        return view('admin.singleimage')->with('image', $image);
    }
    public function reports(){
        return view('admin.reports');
    }
    public function update_user(Request $request, User $user){
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5',
            'question' => 'required',
            'answer' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $user->name = $request->input('name');
        $user->question = $request->input('question');
        $user->answer = $request->input('answer');
        $user->save();
        session()->flash('status', $user->username  ."'s account successfully updated");
        return redirect()->back();
    }
    /**
    *   Suspend or reinstate the user
    *   @param $user is a register member
    *   @return back to the current page
    */
    public function suspend_user(User $user){
        //If the user is active suspend them if not reinstate them
        if ($user->active == 1) {
            $user->active = 0;
            $user->save();
            session()->flash('status', $user->username . ' was successfully suspended');
            return redirect()->back();
        }
        $user->active = 1;
        $user->save();
        session()->flash('status', $user->username . ' was successfully reinstated');
        return redirect()->back();
    }
    public function reset_password(User $user){
        $user->password = bcrypt('default');
        $user->save();
        return redirect()->back();
    }
}
