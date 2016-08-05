<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Image as Img;
use App\Http\Requests;
use Validator;
use App\Album;
use App\Image;
use App\Reports;
use App\Comments;
use Auth;
use DB;
use Storage;


class ImagesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $images = Image::where('user_id', '=', Auth::user()->id)->get();
    	return view('images.all')->with('images', $images);
    }
    // public function serve($album_id, $file){
    //     $currentAlbum = Album::where('album_id', '=', $album_id)->first();
    //     //$image = Image::where('name', '=' , $name)->where('album_id', '=', $album_id)->first();
    //     $path = 'app/' . $currentAlbum->path . '/' . $file;

    //     return Image::make(storage_path($path))->response();
    //     //$images = Image::where('album_id', $album->album_id)->get();
    // }
    // public function showImage($album, $name){

    // }
    public function upload(){

        $categories = DB::table('categories')->get();

    	$currentUser = Auth::user()->id;
    	$albumsCount = Album::where('user_id', $currentUser)->count();
    	if ($albumsCount <= 0) {
    		session()->flash('create-status', 'You must create an album to upload an image');
    		return redirect('/albums');
    	}
    	$albums = Album::where('user_id', $currentUser)->get();
    	return view('images.upload')->with('albums', $albums)->with('categories', $categories);
    }
    public function save_image(Request $request){
    	$validator = Validator::make($request->all(), [
    		'name' => 'required|min:4|max:25',
    		'image' => 'required|image|max:2048',
    		'album' => 'required'
    	]);
    	if ($validator->fails()) {
    		return redirect()->back()->withErrors($validator);
    	}
    	else
    	{
    		$currentUser = Auth::user()->id;
    		$currentAlbum = Album::where('user_id' , '=', $currentUser)->where('name', '=', $request->input('album'))->first();
    		//Current Album
    		$album = Album::find($currentAlbum->album_id);
    		if ($request->hasFile('image')) {
    			$userImage = $request->file('image');
                $filename = uniqid(). '.' . $userImage->getClientOriginalExtension();
                $albumThumbnailName = Auth::user()->username . str_replace(' ', '', $currentAlbum->name) . '.' . $userImage->getClientOriginalExtension();
                $albumThumbnail = Img::make($userImage)->resize(592, 293);
                $image = Img::make($userImage);
                $height = Img::make($userImage)->height();
                $width = Img::make($userImage)->width();
                Storage::put($currentAlbum->path . '/' . $filename, $image->stream());
                Storage::put('users/albums/albums_thumbnail/' . $albumThumbnailName, $albumThumbnail->stream());
                // $thumbnailName = $request->input('name') . '_thumbnail' . '.' . $userImage->getClientOriginalExtension();
                // $thumbnail = Img::make($userImage)->resize(round($width * 0.33), round($height * 0.33));
                // Storage::put($currentAlbum->path . '/' . $thumbnailName, $thumbnail->stream());

                $currentAlbum->thumbnail = $albumThumbnailName;
                $currentAlbum->save();
                $album->image()->create([
	    			'name' => $filename,
	    			'path' => $currentAlbum->path,
	    			'permission' => $currentAlbum->permission,
                    'height' => $height,
                    'width' => $width,
	    			'category' => $request->input('category'),
	    			'mime' => $userImage->getClientMimeType(),
	    			'display_filename' => $request->input('name'),
                    'size' => ($userImage->getClientSize()),
                    'user_id' => Auth::user()->id,
    			]);
    		}
    		return redirect()->back();
    	}
    }
    public function report(Request $request){
        $validator = Validator::make($request->all(), [
            'report' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        Reports::create([
            'reason' => $request->input('report'),
            'image_id' => $request->input('image')
        ]);
        session()->flash('status', 'Image was successfully reported');
        return redirect()->back();
    }
    public function submit_comment(Request $request){
        $validator = Validator::make($request->all(), [
            'user-comment' => 'required|min:4|max:50'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $comment = Comments::create([
            'comment' => $request->input('user-comment'),
            'image_id'=> $request->input('id'),
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->back();
    }
    public function like_image(Request $request, Image $image){
        $likeRecord = DB::table('likes')->where('image_id', $image->image_id)
                          ->where('user_id', Auth::user()->id)
                          ->first();
        if (empty($likeExists)) {
            DB::table('likes')->where('image_id', $image->image_id)
                          ->where('user_id', Auth::user()->id)
                          ->delete();
            DB::table('likes')->insert([
                'image_id' => $image->image_id,
                'user_id' => Auth::user()->id,
            ]);
        }
        return redirect()->back();
    }
    public function view($name){
        $image = Image::where('name', '=', $name)->first();
        $comments = Comments::where('image_id', '=', $image->image_id)->get();
        $currentImage = Image::find($image->image_id);
        $currentImage->views = $currentImage->views + 1; 
        $currentImage->save();
        return view('image')->with('image', $image)->with('comments', $comments);
    }
    /**
     * Delete the given image
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
    */
    public function delete(Request $reqeust, Image $image){
        $this->authorize('destroy', $image);

        if (Storage::disk('local')->exists($image->path . '/' . $image->name)) {
            Storage::delete($image->path . '/' . $image->name);
            $image->delete();
            //Image::where('album_id', $album->album_id)->delete();
            return redirect('/albums');
        }

        abort(404);
    }
}

