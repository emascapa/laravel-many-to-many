<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{

    protected $fillable = ['name', 'slug'];

    //relazione many to many con Post
    public function posts(): BelongsToMany
    {
        # code...
        return $this->belongsToMany(Post::class);
    }
}
