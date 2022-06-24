<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //relazione many to many con Post
    public function posts()
    {
        # code...
        return $this->belongsToMany(Post::class);
    }
}
