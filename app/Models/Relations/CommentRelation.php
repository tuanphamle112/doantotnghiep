<?php

namespace App\Models\Relations;

trait CommentRelation
{
    public function commentable()
    {
        return $this->morphTo();
    }
}
