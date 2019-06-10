<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepositoryEloquent;
use App\Constracts\Eloquent\WishlistRepository;

use App\Models\Wishlist;

class WishlistRepositoryEloquent extends BaseRepositoryEloquent implements WishlistRepository
{
    public $model;

    public function __construct(Wishlist $wishlist)
    {
        $this->model = $wishlist;
    }

    public function showWistList($userId, $recipeId)
    {
        return $this->model->where('user_id', $userId)->where('recipe_id', $recipeId)->first();
    }

    public function allRecipeInWishList($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

}
