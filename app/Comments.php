<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //
    protected $primaryKey = 'comment_id';
    protected $fillable = ['comment', 'image_id', 'user_id'];

    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function image(){
    	return $this->belongTo(Image::class);
    }
}
