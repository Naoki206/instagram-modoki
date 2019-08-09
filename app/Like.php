<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id', 'image_id',];

    public function image()
    {
        return $this->belongsTo('App\Image');
    }
}

