<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Constracts\Eloquent\PostRepository;

use App\Helpers\Helper;
use App\Models\Comment;
use App\Models\Wishlist;

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
    protected $post;

    public function __construct(
        CategoryRepository $category,
        RecipeRepository $recipe,
        UserRepository $user,
        PostRepository $post
    ) {
        $this->category = $category;
        $this->recipe = $recipe;
        $this->user = $user;
        $this->post = $post;
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
        $dataNum = [];
        $dataNum['memberNum'] = count($this->user->all());
        $dataNum['recipeNum'] = count($this->recipe->all());
        $dataNum['postNum'] = count($this->post->all());
        $dataNum['commentNum'] = count(Comment::all());
        $dataNum['love'] = count(Wishlist::all());
        $dataNum['articles'] = $dataNum['recipeNum'] + $dataNum['postNum'];
        $allActiveRecipes = $this->recipe->getAllActiveRecipe(['level', 'comments']);
        $featureRecipe = $this->recipe->getOneFeatureRecipe(['level']);

        $featureMember = $this->user->getFeatureMember();
        $featureMemberList = $this->user->getFeatureMemberList(['recipe', 'post']);

        $latestPost = $this->post->getNewestPostForHomepage();

        $porpularPost = $this->post->getPopularPostForHomepage();

        $popularRecipes = $this->recipe->getPopularRecipesForHomepage();
        // dd($featureMemberList);
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
            'featureMember',
            'latestPost',
            'porpularPost',
            'popularRecipes',
            'featureMemberList',
            'dataNum'
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
