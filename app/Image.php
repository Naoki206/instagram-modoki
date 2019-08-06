<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['img', 'github_name', 'comment'];

    public function users() {
        // return $this->hasMany('App\Post');
        return $this->belongsTo(User::class);
        // return $this->belongsTo(Author::class);
    }
}
