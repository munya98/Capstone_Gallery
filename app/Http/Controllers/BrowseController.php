<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Image;
use Validator;
use DB;

class BrowseController extends Controller
{
	public function __construct(){

	}
    public function index(){
    	$categories = DB::table('categories')->get();
    	return view('browse.browse')->with('categories', $categories);
    }
    public function category($category){
    	$images = Image::where('category', '=' , $category)->where('permission', '=', 'public')->get();
        $catCheck = DB::table('categories')->where('name', $category)->first();
        if (empty($catCheck)) {
            return redirect('/browse');
        }
    	return view('browse.results')->with('images', $images)->with('category', $category);
    }
    public function suggest(Request $request){
        $validator = Validator::make($request->all(), [
            'suggest' => 'required|min:3'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::table('category_suggestion')->insert([
            'name' => $request->input('suggest')
        ]);
        return redirect()->back()->with('suggestion', 'Suggestion noted thank you');
    }
}
