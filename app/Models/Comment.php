<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\CommentRelation;

class Comment extends Model
{
    use CommentRelation;
    
    protected $fillable = [
        'content',
        'user_id',
    ];
}
