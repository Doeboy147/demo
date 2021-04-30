<?php

namespace App\Models;

use Laravel5Helpers\Uuid\UuidModel;

class  Post extends UuidModel
{
    protected $table = 'posts';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'uuid');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Like', 'post_id', 'uuid');
    }

    public function getImage()
    {
        return url('images/posts/'.$this->image);
    }

    public function getImagePath()
    {
        return public_path('images/posts/'.$this->image);
    }
}
