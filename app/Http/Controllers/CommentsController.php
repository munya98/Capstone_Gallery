<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comments;
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
        $validator = Validator::make($request->all(), [
            'user-comment' => 'required|min:4|max:512'
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
    	return $comment;
    }
}
