<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Constracts\Eloquent\LevelRepository;
use App\Models\Gift;
use App\Helpers\Helper;
use Redirect;
use Auth;

class GiftController extends Controller
{
    protected $category;
    protected $recipe;
    protected $user;
    protected $level;

    public function __construct(
        CategoryRepository $category,
        RecipeRepository $recipe,
        LevelRepository $level,
        UserRepository $user
    ) {
        $this->category = $category;
        $this->recipe = $recipe;
        $this->user = $user;
        $this->level = $level;
    }
    public function getCategoriesForNav()
    {
        $categories = [];
        $categoryParents = $this->category->getAllParentCategories();

        foreach ($categoryParents as $categoryParent) {
            $parentId = $categoryParent->id;
            $categoryChildren = $this->category->getChildrenCategories($parentId);

            $categoryParent->children = $categoryChildren;
            $categories[] = $categoryParent;
        }

        return $categories;
    }

    public function index()
    {
        $categories = $this->getCategoriesForNav();
        $gifts = Gift::paginate(10);

        return view('frontend.gifts.index', compact(
            'categories',
            'gifts'
        ));
    }

    public function confirm($id)
    {
        $categories = $this->getCategoriesForNav();
        $user = Auth::user();
        $gift = Gift::findOrFail($id);

        return view('frontend.gifts.confirm', compact(
            'categories',
            'user',
            'gift'
        ));
    }
}
