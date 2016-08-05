<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use Validator;
use App\Album;
use App\User;
use App\Image;
use Auth;
use Storage;
use File;
use DB;

class AlbumsController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }
    /**
    * Get all the albums that belong to the currently logged in user
    *
    * @return Albums view with all the albums that belong to the current user
    */
    public function index(Request $request){
    	$currentUser = Auth::user()->id;
    	$albums = Album::where('user_id', $currentUser)->get();
        // if (Auth::user()->active == 0) {
        //     Auth::logout();
        //     session()->flash('status', 'Your account is suspended');
        //     return redirect('/');
        // }
    	return view('albums.list')->with('albums', $albums);
    }
    /** 
    * Fetch the requested thumbnail for the album
    * @param $file -> The name of the thumbnail
    * @return An image as a HTTP response 
    */
    public function showThumbnail($file){
    	$thumbnail = Storage::get('users/albums/albums_thumbnail/' . $file);
    	return (new Response($thumbnail, 200))->header('Content-Type', 'image/jpeg');
    }

    /**
        The method used to create an album.
    */
    public function create_album(Request $request){
    	/*
			Validate input
    	*/
        //Custom validation messages
        $messages = [
            'regex' => 'The album title may only contain letters numbers and spaces',
            'album-Title.required' => 'The album title is requierd',
            'album-Permission.required' => 'The album permission is requied',
        ];
        //Validate all of the user input
    	$validator = Validator::make($request->all(),[
    		'album-Title' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:20',
            'album-Description' => 'max:200',
    		'album-Permission' => 'required'
    	], $messages);

        //Send back the error messages if an error did occur
    	if($validator->fails()){
    		return redirect()->back()->withErrors($validator);
    	}

    	//Data required to create the folder
    	$username = Auth::user()->username;
    	$permission = $request->input('album-Permission');
    	$name = $request->input('album-Title');
    	$path = 'users/albums/' . $username . '/' . $permission . '/' . $name;

    	/*
			If the folder exists return back with a message
			Otherwise create the folder and save its details in the database
    	*/
    	if (Storage::disk('local')->exists($path)) {
    		return redirect()->back()->with('status', 'This Album Already Exists');
    	}else{
    		Storage::makeDirectory($path);
    		/* Use eloquent to save album information inside the database*/
			$request->user()->albums()->create([
				'name' => $name,
				'path' => $path,
				'description' => $request->input('album-Description'),
				'permission' => $permission,
			]);
			return redirect()->back()->with('status', 'Album was successfully created');
    	}

    }
    /**
    *   Update the current album
    *   @param $request coming in http request
    *   @param $album Current album object
    *   
    */
    public function update(Request $request, Album $album){
        $this->authorize('update', $album);
        //Custom validation messages
        $messages = [
            'regex' => 'The album title may only contain letters numbers and spaces',
            'album-Title.required' => 'The album title is requierd',
            'album-Permission.required' => 'The album permission is requied',
        ];
        //Validate all of the user input
        $validator = Validator::make($request->all(),[
            'album-Title' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:20',
            'album-Description' => 'max:50',
            'album-Permission' => 'required'
        ], $messages);

        //Send back the error messages if an error did occur
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $currentAlbum = Album::find($album->album_id);

        /*  If the user changes the original name, update the name in the database 
        *   and update the name of the album in Storage;
        */
        $currentAlbum->name = $request->input('album-Title');
        $currentAlbum->description = $request->input('album-Description');
        $currentAlbum->permission = $request->input('album-Permission');
        
        $path = 'users/albums/' . Auth::user()->username . '/' . $request->input('album-Permission') . '/' . $request->input('album-Title');
        $currentAlbum->path = $path;
        if (Storage::disk('local')->exists($path)) {
            abort(409);
        }
        Storage::move($album->path, $path);
        $currentAlbum->save();
        return redirect('albums/' . $request->input('album-Title'));
    }
    /**
    *   Display the requested album
    *   @param 
    *   @return 
    *   or
    *   @return 
    */
    public function displayAlbum($albumName){
        $categories = DB::table('categories')->get();
    	$album = Album::where('user_id' , '=', Auth::user()->id)->where('name', '=', $albumName)->first();
        if(empty($album)){
           abort(404);
        }
    	$images = Image::where('album_id', $album->album_id)->simplePaginate(12);
    	return view('albums.details')->with('images', $images)->with('album', $album)->with('categories', $categories);
    }

    /** 
    *   Delete an album
    *   @param $request
    */
    public function purge(Request $request, Album $album){
        $this->authorize('purge', $album);
        //$album->delete();
        if (Storage::disk('local')->exists($album->path)) {
            Storage::deleteDirectory($album->path);
            $album->delete();
            Image::where('album_id', $album->album_id)->delete();
            return redirect('/albums');
        }
        abort(404);
    }
}
