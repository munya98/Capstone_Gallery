<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    //
    protected $primaryKey = 'album_id';
    protected $fillable = [
    	'name', 'path', 'description', 'permission', 'thumbnail',
    ];
    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function image() {
    	return $this->hasMany(Image::class);
    }
}
