<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\Album;
use App\Image as Img;
use Auth;
use Storage;
use Image;
use Validator;
use Hash;
use App\Http\Requests;
use DB;

class AccountController extends Controller
{
    /**
    *   Authorize all routes that pass through this class
    *   @return void 
    */
    public function __construct(){
    	$this->middleware('auth');
    }

    /**
    *   Load account details view
    *   @return account details view
    */
    public function index(){
    	return view('account.details');
    }

    /**
    *   Load edit account details view
    *   @return edit account details view
    */
    public function edit(){
    	return view('account.edit');
    }
    
    /**
    *   Load avatar view
    *   @return update avatar view
    */
    public function avatar(){
        return view('account.avatar');
    }

    /**
    *   Load view used to change the current password
    *   @return password update view
    */
    public function password(){
        return view('account.updatepassword');
    }

    /**
    *   Update Account Information
    *   @return redirect back to current page with error messages if an error occured 
    *    or
    *   @return redirect back to current page with a success message
    */
    public function edit_details(Request $request){
        if (Auth::user()->username == $request->input('username')) {
                $validator = Validator::make($request->all(), [
                'name' => 'required|min:3|max:25',
                'question' => 'required|min:10',
                'answer' => 'required|min:5',
                'bio' => 'max:255',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }
            //Update the user's information if no error occcured
            $user = User::find(Auth::user()->id);
            $user->name = $request->input('name');
            $user->question = $request->input('question');
            $user->answer = $request->input('answer');
            $user->bio = $request->input('bio');
            $user->save();
            return redirect()->back();
        }
        else {
            //Validate incoming request
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3|max:25',
                'username' => 'required|min:4|max:25|unique:users|alpha_num',
                'question' => 'required|min:10',
                'answer' => 'required|min:5',
            ]);

            //Return error messages if an error occured
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }

            //Update the user's information if no error occcured
            $user = User::find(Auth::user()->id);
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->question = $request->input('question');
            $user->answer = $request->input('answer');
            $user->bio = $request->input('bio');
            $user->avatar = $request->input('username') . substr($request->input('avatar'), -4);
            Storage::move('avatars/' . Auth::user()->avatar, 'avatars/' . $request->input('username') . substr($request->input('avatar'), -4));
            $user->save();

            //If the user has any albums
            try {
                $albumsCount = Album::where('user_id', Auth::user()->id)->count();
                if ($albumsCount > 0) {
                    $albums = Album::where('user_id', Auth::user()->id)->get();
                    foreach ($albums as $album) {
                        $album->path = 'users/albums/' . $request->input('username') . '/' . $album->permission . '/' . $album->name;
                        $album->save();
                        $images = Img::where('album_id', $album->album_id)->get();
                        foreach ($images as $img) {
                            $img->path = $album->path;
                            $img->save();
                        }
                    }
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
            Storage::move('users/albums/' . Auth::user()->username, 'users/albums/' . $request->input('username'));
            return redirect()->back();
        }
    }

    /**
    *   Update Account Password
    *   @return redirect back to current page with error messages if an error occured 
    *    or
    *   @return redirect back to current page with a success message
    */
    public function update_password(Request $request){
        $messages = [
            'current.required' => 'The current password field is required',
        ];
        $validator = Validator::make($request->all(), [
            'current' => 'required',
            'password' => 'required|confirmed|min:6',
        ], $messages );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        if((Hash::check($request->input('current'), Auth::user()->password))){
            $user = User::find(Auth::user()->id);

            $user->password = bcrypt($request->input('password'));

            $user->save();
            session()->flash('status', 'Your password was succesfully updated');
            return redirect()->back();  
        }else {
            session()->flash('status', 'Password not updated, incorrect current password');
            return redirect()->back();
        }        
    }
    /**
    *   Delete/Deactivate Account
    *   @return 
    */
    public function purge(){
    	return view('account.purge');
    }
    public function social(){
        return view('account.social');
    }
    /**
    *   User_id needs to be unique
    *   if exists update update otherwise insert
    *
    */
    public function social_update(Request $request){
        DB::table('social')->insert([
            'twitter' => $request->input('twitter'),
            'instagram' => $request->input('instagram'),
            'facebook' => $request->input('facebook'),
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->back();
    }
    public function delete(Request $request, User $user) {
        $account = User::find($user->id);
        //Check if record passed matches the currently logged in user
        if($account->id != Auth::user()->id){
            return "You do not own this account";
        }else {
            Storage::deleteDirectory('/users/albums/'. $account->username);
            $account->delete();
            return redirect('/');
        }
    }
    /**
    *   Update Account Avatar
    *   @return redirect back to current page with error messages if an error occured 
    *    or
    *   @return redirect back to current page with a success message
    */
    public function update_avatar(Request $request){
        $errors = [
            'required' => 'Please choose a file before you submit'
        ];
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|max:2048'
        ], $errors);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }else{
            $user = Auth::user();
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = $user->username . '.' . $avatar->getClientOriginalExtension();
                $act = Image::make($avatar)->resize(300,300);
                Storage::put('avatars/' . $filename, $act->stream());
                $user->avatar = $filename;
                $user->save();
            }
            session()->flash('status', 'Avatar successfully updated');
            return redirect()->back();
        }
    }
}
