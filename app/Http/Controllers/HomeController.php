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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $imagesPagination = Image::where('permission', 'public')
                                   ->OrderBy('created_at', 'desc')
                                   ->paginate(30);
        // $images = Image::where('permission', 'public')->get();
        // $owners = array();
        // foreach ($images as $img) {
        //     $owner = User::find($img->user_id);
        //     array_push($imagesPagination, $owner);
        // }
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

    public function serve($album_id, $file){
        $currentAlbum = Album::where('album_id', '=', $album_id)->first();
        //$image = Image::where('name', '=' , $name)->where('album_id', '=', $album_id)->first();
        $path = 'app/' . $currentAlbum->path . '/' . $file;

        return Img::make(storage_path($path))->response();
        //$images = Image::where('album_id', $album->album_id)->get();
    }
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
    public function view($name){
        $categories = DB::table('categories')->inRandomOrder()
                                             ->take(13)
                                             ->get();
        $allcategories = DB::table('categories')->get();
        $image = Image::where('name', '=', $name)->first();
        $liked = false;
        if (!(Auth::guest())) {
          $like = DB::table('likes')->where('image_id', $image->image_id)
                                  ->where('user_id', Auth::user()->id)->first();
          if (!empty($like)) {
            $liked = true;
          }
        }
        if (empty($image)) {
            abort(404);
        }
        $comments = Comments::where('image_id', '=', $image->image_id)->simplePaginate(20);
        $commenter = array();
        foreach ($comments as $c) {
          $user = User::find($c->user_id);
          array_push($commenter, $user);
        }
        // $owners = array();
        // foreach ($images as $img) {
        //     $owner = User::find($img->user_id);
        //     array_push($imagesPagination, $owner);
        // }
        $currentImage = Image::find($image->image_id);
        $currentImage->views = $currentImage->views + 1; 
        $currentImage->save();
        $owner = User::find($currentImage->user_id);
        $suggestions = DB::table('images')->select('thumbnail', 'album_id', 'name')
                                          ->where('user_id', $currentImage->user_id)
                                          ->where('permission', 'public')
                                          ->inRandomOrder()
                                          ->take(15)
                                          ->get();
        $likes = DB::table('likes')->where('image_id', $image->image_id)->count();
        return view('images.view')->with('image', $image)
                                  ->with('comments', $comments)
                                  ->with('owner', $owner)
                                  ->with('suggestions', $suggestions)
                                  ->with('categories', $categories)
                                  ->with('likes', $likes)
                                  ->with('commenter', $commenter)
                                  ->with('liked', $liked)
                                  ->with('allcategories', $allcategories);
    }
}
