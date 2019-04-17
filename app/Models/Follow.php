<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\FollowRelation;

class Follow extends Model
{
    use FollowRelation;
    
    protected $fillable = [
        'user_id',
        'user_id_follow',
    ];
}
