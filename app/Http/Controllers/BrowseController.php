<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Image;

class BrowseController extends Controller
{
	public function __construct(){

	}
    public function index(){
    	$categories = ['Abstract', 'Anime', 'Auto and Vehicles', 'Black and White', 'Comedy', 'Designs', 'Cartoons' ,'Drawings', 'Entertainment', 'Games', 'Holidays','Seasons', 'Logos', 'Music', 'Nature' , 'Landscape', 'News' , 'Politics', 'Other', 'Pets and Animals', 'Quotes', 'Spiritual', 'Sports', 'Technology'];

    	return view('browse.browse')->with('categories', $categories);
    }
    public function category($category){
        $categories = ['Abstract', 'Anime', 'Auto and Vehicles', 'Black and White', 'Comedy', 'Designs', 'Cartoons' ,'Drawings', 'Entertainment', 'Games', 'Holidays','Seasons', 'Logos', 'Music', 'Nature' , 'Landscape', 'News' , 'Politics', 'Other', 'Pets and Animals', 'Quotes', 'Spiritual', 'Sports', 'Technology'];
    	$images = Image::where('category', '=' , $category)->where('permission', '=', 'public')->get();
        if(!in_array($category, $categories)){
            return redirect('/browse');
        }
    	return view('browse.results')->with('images', $images)->with('category', $category);
    }
}
