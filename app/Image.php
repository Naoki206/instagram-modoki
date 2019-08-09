<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['img', 'github_name', 'comment'];

    public function user() {
        // return $this->hasMany('App\Post');
        return $this->belongsTo('App\User');
        // return $this->belongsTo(Author::class);
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
        // ->where('image_flg', 1);
    }
}
