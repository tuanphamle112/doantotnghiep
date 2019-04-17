<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\WishlistRelation;

class Wishlist extends Model
{
    use WishlistRelation;
    
    protected $fillable = [
        'user_id',
        'recipe_id',
        'status',
    ];
}
