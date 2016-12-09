<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comments;
use App\Image;
use Validator;
use Auth;
use App\Http\Requests;

class CommentsController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }
    public function submit_comment(Request $request){
        //Update the views on the image
        $currentImage = Image::find($request->input('id'));
        $currentImage->views = $currentImage->views - 1; 
        $currentImage->save();
        $validator = Validator::make($request->all(), [
            'user-comment' => 'required|min:1|max:512'
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
    public function delete_comment(Comments $comment){
        $comment->delete();
    	return redirect()->back();
    }
}
