<?php

namespace App\Models\Relations;

use App\User;
trait CommentRelation
{

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
