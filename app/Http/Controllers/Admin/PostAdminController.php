<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constracts\Eloquent\UserRepository;
use App\Constracts\Eloquent\PostRepository;
use App\Constracts\Eloquent\RecipeRepository;

class PostAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $post;
    protected $user;
    protected $recipe;

    public function __construct(
        PostRepository $post,
        UserRepository $user,
        RecipeRepository $recipe
    ) {
        $this->post = $post;
        $this->user = $user;
        $this->recipe = $recipe;
    }
    
    public function index()
    {
        $posts = $this->post->getAllPostsDesc(config('manual.pagination.post'), ['user']);
        $recipes = $this->recipe->getAllRecipeDesc(config('manual.pagination.recipe'), ['level']);

        return view('admin.posts.index', compact(
            'posts',
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

    public function updateStatus($id)
    {
        $post = $this->post->findOrFail($id);

        $currentPoint = $post->user->star_num;
        $newPoint = $currentPoint + config('manual.star_num.be_commented');

        $post->status = config('manual.post_status.Actived');

        $post->save();
        $this->user->getNewestStarPoint($post->user->id, $newPoint);

        $notification = [
            'message' => __('Accept post successfully!'),
            'alert-type' => 'success',
        ];

        return redirect()->route('manage-post.index')->with($notification);
    }
}
