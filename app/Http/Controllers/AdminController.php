<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Image;
use App\Album;
use DB;
use Validator;
use App\Http\Requests;
use Storage;

class AdminController extends Controller
{

    /**
    *   Authorize all routes that pass through this class
    *   @return void 
    */
	public function __construct(){
		$this->middleware('auth');
		$this->middleware('role:Admin');
	}

    /**
    *   Initial dashboard state
    *   @return Dashboard View
    */
    public function index(){
    	$users = User::all();
    	$totalUsers = User::all()->count();
    	$totalImages = Image::all()->count();
    	$totalAlbums = Album::all()->count();

        //Latest Image
    	$latestImage = Image::OrderBy('created_at','desc')->first();

        //Latest Images
    	$recentImages = DB::table('images')->where('image_id', '<>', $latestImage->image_id)
    									   ->OrderBy('created_at', 'desc')
    									   ->take(10)->get();

        //Recent Users
    	$recentUsers = DB::table('users')->OrderBy('created_at', 'desc')->take(5)->get();

        //Return dashboard
    	return view('admin.dashboard')->with('users', $users)
    								  ->with('totalUsers', $totalUsers)
    								  ->with('totalImages', $totalImages)
    								  ->with('totalAlbums', $totalAlbums)
    								  ->with('latestImage', $latestImage)
    								  ->with('recentImages', $recentImages)
    								  ->with('recentUsers', $recentUsers);
    }

    /**
    *   Search for a user using username or name
    *   @return user data as json
    */
    public function search_user(Request $request){
        $search = $request->input('term');
        $users = User::where('name', 'like' , "%$search%")
                       ->orwhere('username', 'like', "%$search%")
                       ->get();
        return response()->json($users, 200);
    }
    /**
    *   Search for a user using username or name
    *   @return user data as json
    */
    public function users(){
        $users = DB::table('users')->paginate(25);
        return view('admin.users')->with('users', $users);
    }
    /**
    *   Search for a user using username or name
    *   @param User class
    *   @return user data as json
    */
    public function view_user(User $user){
        $images = Image::where('user_id', $user->id)->count();
        $albums = Album::where('user_id', $user->id)->count();
        $likes= DB::table('likes')->where('user_id', $user->id)->count();
        return view('admin.singleuser')->with('user', $user)
                                       ->with('images', $images)
                                       ->with('albums', $albums)
                                       ->with('likes', $likes);
    }
    /**
    *   Search for a user using username or name
    *   @return user data as json
    */
    public function albums(){
        $albums = Album::all();
        return view('admin.albums')->with('albums', $albums);
    }
    /**
    *   View an album
    *   @param Ablum class
    *   @return Single Album view with selected album and images in the album
    */
    public function view_album(Album $album){
        $images = Image::where('album_id', $album->album_id)->get();
        return view('admin.singlealbum')->with('album', $album)
                                        ->with('images', $images);
    }
    /**
    *   View images paginated to 15 per page
    *   @return Images view with images
    */
    public function images(){
        $images = DB::table('images')->simplePaginate(15);
        return view('admin.images')->with('images', $images);
    }
    /**
    *   View single image
    *   @param Image class 
    *   @return Single image view with reports, likes and the selected image
    */
    public function view_image(Image $image){
        $reports = DB::table('reports')->where('image_id', $image->image_id)->simplePaginate(10);
        $likes = DB::table('likes')->where('image_id', $image->image_id)->count();
        return view('admin.singleimage')->with('image', $image)
                                        ->with('likes', $likes)
                                        ->with('reports', $reports);
    }
    /**
    *   Delete selected image
    *   @param Image class
    *   @return redirect back to all images
    *   or
    *   @return 404 page if image is not found
    */
    public function delete_image(Image $image){
        $album = Album::find($image->album_id);
        if (Storage::disk('local')->exists($album->path . '/' . $image->name)) {
            Storage::delete($album->path . '/' . $image->name);
            $image->delete();
            return redirect('admin/images');
        }
        abort(404);
    }
    /**
    *   Fetch reports, suggestions and categories
    *   @return Reports view
    */
    public function reports(){
        $reports = DB::table('reports')->paginate(25);
        $suggestions = DB::table('category_suggestion')->paginate(25);
        $categories = DB::table('categories')->paginate(25);
        return view('admin.reports')->with('reports', $reports)
                                    ->with('suggestions', $suggestions)
                                    ->with('categories', $categories);
    }
    /**
    *   Add A category
    *   @param category name
    *   @return redirect back to the current page
    */
    public function add_category($category){
        $categories = DB::table('categories')->where('name', $category)->first();

        if(!empty($categories)) {
            session()->flash('status', 'Category Already Exists');
            return redirect()->back();
        }

        DB::table('categories')->insert(['name' => $category]);
        session()->flash('status', 'Category successfully added');
        return redirect()->back();
    }
    /**
    *   Delete Category
    *   @param category name
    *   @return redirect back
    */
    public function del_category($category){
        DB::table('category_suggestion')->where('category_id', $category)->delete();
        session()->flash('status', 'Category suggestion deleted');
        return redirect()->back();
    }
    /**
    *   Update user's account
    *   @param Incoming request
    *   @param User class
    *   @return redirect back
    */
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
        $user->bio = $request->input('bio');
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
    /**
    *   Reset a users password to 'default'
    *   @return redirect back
    */
    public function reset_password(User $user){
        $user->password = bcrypt('default');
        $user->save();
        return redirect()->back();
    }
}
