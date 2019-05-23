<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\UserRepository;

use App\Helpers\Helper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $category;
    protected $recipe;
    protected $user;

    public function __construct(
        CategoryRepository $category,
        RecipeRepository $recipe,
        UserRepository $user
    ) {
        $this->category = $category;
        $this->recipe = $recipe;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = [];
        $categoryParents = $this->category->getAllParentCategories();
        $allActiveRecipes = $this->recipe->getAllActiveRecipe(['level']);
        $featureRecipe = $this->recipe->getOneFeatureRecipe(['level']);
        $featureMember = $this->user->getFeatureMember();
        
        foreach ($categoryParents as $categoryParent) {
            $parentId = $categoryParent->id;
            $categoryChildren = $this->category->getChildrenCategories($parentId);

            $categoryParent->children = $categoryChildren;
            $categories[] = $categoryParent;
        }
        return view('frontend.homepage', compact(
            'categories',
            'allActiveRecipes',
            'featureRecipe',
            'featureMember'
        ));
    }

    public function changeLanguage(Request $request)
    {
        $lang = $request->language;
        
        $language = config('app.locale');

        if ($lang == 'en') {
            $language = 'en';
        }
        
        if ($lang == 'vi') {
            $language = 'vi';
        }
        Helper::setLanguage($language);

        return redirect()->back();
    }
}
