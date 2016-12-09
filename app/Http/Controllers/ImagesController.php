<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Image as Img;
use App\Http\Requests;
use Validator;
use App\Album;
use App\Image;
use App\Reports;
use App\Comments;
use App\User;
use Auth;
use DB;
use Storage;

class ImagesController extends Controller
{
    /**
    *   Constructor - all routes passing through here need authorization
    */
    public function __construct(){
        $this->middleware('auth');
    }
    /**
    *   Show all images that belong to the currently authenticated user   
    */
    public function index(){

        $currentUser = User::where('username', Auth::user()->username)->first();
        $images = Image::where('user_id', '=', $currentUser->id)->simplePaginate(30);
        $imageCount = Image::where('user_id', '=', $currentUser->id)->count();
        $albumCount = Album::where('user_id', '=', $currentUser->id)->count();
    	return view('images.all')->with('user', $currentUser)
                                  ->with('images', $images)
                                  ->with('img_count', $imageCount)
                                  ->with('album_count', $albumCount);
    }

    public function private_images(){
        $currentUser = User::where('username', Auth::user()->username)->first();
        $images = Image::where('user_id', '=', $currentUser->id)->where('permission','private')->simplePaginate(30);
        $imageCount = Image::where('user_id', '=', $currentUser->id)->count();
        $albumCount = Album::where('user_id', '=', $currentUser->id)->count();
        return view('images.private')->with('user', $currentUser)
                                  ->with('images', $images)
                                  ->with('img_count', $imageCount)
                                  ->with('album_count', $albumCount);
    }

    public function public_images(){
        $currentUser = User::where('username', Auth::user()->username)->first();
        $images = Image::where('user_id', '=', $currentUser->id)->where('permission','public')->simplePaginate(30);
        $imageCount = Image::where('user_id', '=', $currentUser->id)->count();
        $albumCount = Album::where('user_id', '=', $currentUser->id)->count();
        return view('images.public')->with('user', $currentUser)
                                  ->with('images', $images)
                                  ->with('img_count', $imageCount)
                                  ->with('album_count', $albumCount);
    }
    /**
    *   Show the image upload page 
    */
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
    /**
    *   Save an image to storage   
    */
    public function save_image(Request $request){
        //Rules
        $rules = [
            'name' => 'required|min:4|max:25',
            'album' => 'required'
        ];

        //Custom rule for image
        $images = count($request->input('image'));
        foreach (range(0, $images) as $image) {
            $rules['image.' . $image] = 'required|image|max:1024';
        }
    	$validator = Validator::make($request->all(), $rules);
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
    			$userImages = $request->file('image');
                foreach($userImages as $userImage){
                    $filename = uniqid(rand(), true). '.' . $userImage->getClientOriginalExtension();
                    $albumThumbnailName = Auth::user()->username . str_replace(' ', '', $currentAlbum->name) . '.' . $userImage->getClientOriginalExtension();
                    $albumThumbnail = Img::make($userImage)->resize(592, 293);
                    $image = Img::make($userImage);
                    $height = Img::make($userImage)->height();
                    $width = Img::make($userImage)->width();
                    Storage::put($currentAlbum->path . '/' . $filename, $image->stream());
                    Storage::put('users/albums_thumbnail/' . $albumThumbnailName, $albumThumbnail->stream());
                    $thumbnailName = 'thumbnail' . $filename;
                    $thumbnail = Img::make($userImage)->resize(round($width * 0.30), round($height * 0.30));
                    Storage::put($currentAlbum->path . '/' . $thumbnailName, $thumbnail->stream());
                    $albumThumbnail->destroy();
                    $image->destroy();
                    
                    $currentAlbum->thumbnail = $albumThumbnailName;
                    $currentAlbum->save();
                    $album->image()->create([
                        'name' => $filename,
                        //'path' => $currentAlbum->path,
                        'permission' => $currentAlbum->permission,
                        'height' => $height,
                        'width' => $width,
                        'thumbnail' => $thumbnailName,
                        'category' => $request->input('category'),
                        'mime' => $userImage->getClientMimeType(),
                        'display_filename' => $request->input('name'), //Might Need Fixing
                        'size' => ($userImage->getClientSize()),
                        'user_id' => Auth::user()->id,
                    ]);

                }
    		}
            session()->flash('status', 'Image Was successfully uploaded');
    		return redirect()->back();
    	}
    }
    /**
    *   Report an image
    *   @param $user - Current user
    *   @return Images from current user
    *   
    */
    public function report(Request $request){
        $validator = Validator::make($request->all(), [
            'report' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Please select and option'], 200);
        }
        Reports::create([
            'reason' => $request->input('report'),
            'image_id' => $request->input('image')
        ]);
        return response()->json(['success' => 'Image was successfully reported'], 200);
    }
    /**
    *   Like an image
    *   @param $image - Current user
    *   @return image liked respone
    *   
    */
    public function like_image(Image $image){
        $like = DB::table('likes')->where('image_id', $image->image_id)
                          ->where('user_id', Auth::user()->id)
                          ->get();
        //Toggle between like or did not like(neutral)
        if (!empty($like)) {
            DB::table('likes')->where('image_id', $image->image_id)
                              ->where('user_id', Auth::user()->id)
                              ->delete();
            
        }else{
            DB::table('likes')->insert([
                'image_id' => $image->image_id,
                'user_id' => Auth::user()->id,
            ]);
        }
        $liked = false;
        //Check if the current user liked the image
        if (!(Auth::guest())) {
          $like = DB::table('likes')->where('image_id', $image->image_id)
                                  ->where('user_id', Auth::user()->id)->first();
          if (!empty($like)) {
            $liked = true;
          }
        }
        $likes = DB::table('likes')->where('image_id', $image->image_id)->count();
        return response()->json(['liked' => $liked, 'likes' => $likes]);
    }
    // /**
    // *   
    // *   @param $user - Current user
    // *   @return Images from current user
    // *   
    // */
    // public function view($name){
    //     $image = Image::where('name', '=', $name)->first();
    //     $comments = Comments::where('image_id', '=', $image->image_id)->get();
    //     $currentImage = Image::find($image->image_id);
    //     $currentImage->views = $currentImage->views + 1; 
    //     $currentImage->save();
    //     return view('image')->with('image', $image)->with('comments', $comments);
    // }
    /**
    *   Update image details
    *   @param $image- Image being updated
    *   @return redirect back with errors or without errors based on validation
    *   
    */
    public function update(Image $image, Request $request){
         //Update the views on the image
        $image->views = $image->views - 1; 
        $image->save();
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:25'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $image->display_filename = $request->input('name');
        $image->category = $request->input('category');
        $image->save();
        return redirect()->back();
    }
    /**
     * Delete the given image
     *
     * @param  Image $image
     * @return Response
    */
    public function delete(Image $image){
        $this->authorize('destroy', $image);
        $album = Album::find($image->album_id);
        if (Storage::disk('local')->exists($album->path . '/' . $image->name)) {
            Storage::delete($album->path . '/' . $image->name);
            $image->delete();
            return redirect('albums/' . $album->name);
        }
        abort(404);
    }
}
