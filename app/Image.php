<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $primaryKey = 'image_id';
    protected $fillable = [
    	'name','path', 'permission', 'category', 'mime', 'display_filename', 'size', 'thumbnail', 'user_id', 'height', 'width',
    ];

    public function album(){
    	return $this->belongsTo(Album::class);
    }
    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function comments(){
        return $this->hasMany(Comments::class);
    }
}
