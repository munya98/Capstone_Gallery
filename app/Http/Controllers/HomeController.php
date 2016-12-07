<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Image;
use App\Album;
use App\User;
use App\Comments;
use Image as Img;
use Validator;
use DB;
use Auth;
class HomeController extends Controller
{    
    /**
     *  Show the application homepage.
     *  @param incoming request
     *  @return Paginated list of images
     */
    public function index(Request $request)
    {   
        $imagesPagination = Image::where('permission', 'public')
                                   ->OrderBy('created_at', 'desc')
                                   ->paginate(30);
        if ($request->input('sort') != null) {
          switch($request->input('sort')){
            case 'latest':
              $imagesPagination = Image::where('permission', 'public')
                                     ->OrderBy('created_at', 'desc')
                                     ->paginate(30);
            break;
            case 'old':
              $imagesPagination = Image::where('permission', 'public')
                                     ->OrderBy('created_at', 'asc')
                                     ->paginate(30);
            break;
            case 'popular':
              $imagesPagination = Image::where('permission', 'public')
                                     ->OrderBy('views', 'desc')
                                     ->paginate(30);
            break;
            default:
              $imagesPagination = Image::where('permission', 'public')
                                   ->OrderBy('created_at', 'desc')
                                   ->paginate(30);
            break;
          }
        }
        return view('welcome')->with('images', $imagesPagination);
    }

    /**
     *  Get an in image from storage
     *  @param $album_id - Album the image belongs too
     *  @param $file - Name of the image
     *  @return image from storage
     */
    public function serve($album_id, $file){
        $currentAlbum = Album::where('album_id', '=', $album_id)->first();
        $path = 'app/' . $currentAlbum->path . '/' . $file;
        return Img::make(storage_path($path))->response();
    }
    /**
     *  Search for a image
     *  @param incoming request
     *  @return Paginated list of images
     */
    public function search(Request $request){
        if ($request->input('search') == null) {
          return redirect('/');
        }else{
          $validator = Validator::make($request->all(),[
            'search' => 'required|min:3'
          ]);
          if($validator->fails()){
              return redirect()->back()->withErrors($validator);
          }
          $term = $request->input('search');
          $images = Image::where('display_filename', 'LIKE', "%$term%")->simplePaginate(30);
          return view('search')->with('images', $images)->with('term', $term);
        }
    }
    /**
     *  View an image
     *  @param $name - name of the image
     *  @return Paginated list of images
     */
    public function view($name){

        //List of suggested categories
        $categories = DB::table('categories')->inRandomOrder()
                                             ->take(13)
                                             ->get();
        //All categories used for updating the image details
        $allcategories = DB::table('categories')->get();

        //Get the image, return 404 if the image is not found
        $image = Image::where('name', '=', $name)->first();
        $liked = false;
        if (empty($image)) {
            abort(404);
        }
        //Check if the user liked the image
        if (!(Auth::guest())) {
          $like = DB::table('likes')->where('image_id', $image->image_id)
                                  ->where('user_id', Auth::user()->id)->first();
          if (!empty($like)) {
            $liked = true;
          }
        }
        //Get a list of comments on the image
        $comments = Comments::where('image_id', '=', $image->image_id)->simplePaginate(10);
        $commenter = array();
        foreach ($comments as $c) {
          $user = User::find($c->user_id);
          array_push($commenter, $user);
        }
        //Update the views on the image
        $currentImage = Image::find($image->image_id);
        $currentImage->views = $currentImage->views + 1; 
        $currentImage->save();
        $owner = User::find($currentImage->user_id);
        //Get the number of images the the current owner has
        $owner_images = Image::where('user_id', $owner->id)
                                    ->where('permission', 'public')
                                    ->count();
        //Suggested images
        $suggestions = DB::table('images')->select('thumbnail', 'album_id', 'name')
                                          ->where('user_id', $currentImage->user_id)
                                          ->where('permission', 'public')
                                          ->inRandomOrder()
                                          ->take(15)
                                          ->get();
        //Number of likes
        $likes = DB::table('likes')->where('image_id', $image->image_id)->count();

        //Return all of the information
        return view('images.view')->with('image', $image)
                                  ->with('comments', $comments)
                                  ->with('owner', $owner)
                                  ->with('owner_images',$owner_images)
                                  ->with('suggestions', $suggestions)
                                  ->with('categories', $categories)
                                  ->with('likes', $likes)
                                  ->with('commenter', $commenter)
                                  ->with('liked', $liked)
                                  ->with('allcategories', $allcategories);
    }
}
