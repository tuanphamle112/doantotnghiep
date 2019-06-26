<?php

namespace App\Models\Relations;

use App\User;

trait GiftRelation
{
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
