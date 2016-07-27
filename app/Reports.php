<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    //
    protected $fillable = [
    	'reason', 'image_id'
    ];

    public function images(){
    	return $this->belongsTo(Image::class);
    }
}
