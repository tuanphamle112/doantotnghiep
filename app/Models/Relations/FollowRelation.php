<?php

namespace App\Models\Relations;

use App\User;

trait FollowRelation
{
    public function getUserBeFollow()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUserFollowing()
    {
        return $this->belongsTo(User::class, 'user_id_follow');
    }
}
