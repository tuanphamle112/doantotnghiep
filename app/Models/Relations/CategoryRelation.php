<?php

namespace App\Models\Relations;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\Post;

trait CategoryRelation
{
    public function recipe()
    {
        return $this->belongsToMany(Recipe::class);
    }

    public function getSubCategory()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function getParentCategory()
    {
        return $this->belongsTo(category::class, 'parent_id');
    }

    public function post()
    {
        return $this->belongsToMany(Post::class);
    }
}
