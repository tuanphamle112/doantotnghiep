<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Constracts\Eloquent\WishlistRepository;

use Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $category;
    protected $recipe;
    protected $user;
    protected $wishlist;

    public function __construct(
        WishlistRepository $wishlist,
        CategoryRepository $category,
        RecipeRepository $recipe,
        UserRepository $user
    ) {
        $this->category = $category;
        $this->recipe = $recipe;
        $this->user = $user;
        $this->wishlist = $wishlist;
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
        $paginate = config('manual.pagination.recipe_home');
        $wishlist = $this->wishlist->allRecipeInWishList(Auth::user()->id);

        $recipes = [];

        foreach ($wishlist as $item) {
            array_push($recipes, $item->recipe);
        }

        return view('frontend.wishlist.index', compact(
            'categories',
            'recipes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->wishlist->create($request->all());

        return response()->json([
            'success' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->wishlist->destroy($id);

        return response()->json([
            'success' => 'success'
        ]);
    }
}
