<?php

namespace App\Constracts\Eloquent;

use App\Constracts\Eloquent\BaseRepository;

interface WishlistRepository extends BaseRepository
{
    public function showWistList($userId, $recipeId);

    public function allRecipeInWishList($userId);

}
