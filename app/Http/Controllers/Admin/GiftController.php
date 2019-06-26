<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\LevelRepository;
use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\WishlistRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Constracts\Eloquent\PostRepository;
use App\Helpers\Helper;
use App\Models\Gift;

use Auth;
use Storage;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $recipe;
    protected $level;
    protected $category;
    protected $wishlist;
    protected $user;
    protected $post;

    public function __construct(
        RecipeRepository $recipe,
        LevelRepository $level,
        WishlistRepository $wishlist,
        CategoryRepository $category,
        UserRepository $user,
        PostRepository $post
    ) {
        $this->recipe = $recipe;
        $this->level = $level;
        $this->category = $category;
        $this->wishlist = $wishlist;
        $this->user = $user;
        $this->post = $post;
    }
    
    public function index()
    {
        $gifts = Gift::paginate(4);
        $recipes = $this->recipe->getAllRecipeDesc(config('manual.pagination.recipe'), ['level']);
        $wishlist = $this->wishlist->all();
        $users = $this->user->all();
        $posts = $this->post->all();

        return view('admin.gifts.index', compact(
            'gifts',
            'recipes',
            'wishlist',
            'users',
            'posts'
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
        //
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
        //
    }
}
