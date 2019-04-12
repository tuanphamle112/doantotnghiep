<?php

namespace App\Models\Relations;

use App\User;
use App\Models\Category;
use App\Models\Comment;

trait PostRelation
{
    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
