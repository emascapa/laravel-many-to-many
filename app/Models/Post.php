<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    //
    protected $fillable = ['title', 'slug', 'image', 'content', 'date', 'category_id'];

    public function category(): BelongsTo
    {
        # code...
        return $this->belongsTo(Category::class);
    }

    //relazione many to many con Tag
    public function tags()
    {
        # code...
        return $this->belongsToMany(Tag::class);
    }
}
