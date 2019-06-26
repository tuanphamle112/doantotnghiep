<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Constracts\Eloquent\CommentRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Constracts\Eloquent\LevelRepository;
use App\Constracts\Eloquent\CategoryRepository;
use App\Constracts\Eloquent\WishlistRepository;
use App\Constracts\Eloquent\PostRepository;
use App\Helpers\Helper;
use Auth;

class CommentController extends Controller
{
    protected $comment;
    protected $recipe;
    protected $user;
    protected $level;
    protected $category;
    protected $wishlist;
    protected $post;

    public function __construct(
        CommentRepository $comment,
        RecipeRepository $recipe,
        UserRepository $user,
        LevelRepository $level,
        WishlistRepository $wishlist,
        CategoryRepository $category,
        PostRepository $post
        ) {
        $this->comment = $comment;
        $this->recipe = $recipe;
        $this->user = $user;
        $this->level = $level;
        $this->category = $category;
        $this->wishlist = $wishlist;
        $this->post = $post;
    }

    public function recipeComment()
    {
        $comments = $this->comment->getAllRecipeComment(config('manual.pagination.comment'));
        $recipes = $this->recipe->getAllRecipeDesc(config('manual.pagination.recipe'), ['level']);
        $wishlist = $this->wishlist->all();
        $users = $this->user->all();
        $posts = $this->post->all();

        return view('admin.comments.index', compact(
            'comments',
            'recipes',
            'wishlist',
            'users',
            'posts'
        ));
    }

    public function postComment()
    {
        $comments = $this->comment->getAllPostComment(config('manual.pagination.comment'));
        $recipes = $this->recipe->getAllRecipeDesc(config('manual.pagination.recipe'), ['level']);
        $wishlist = $this->wishlist->all();
        $users = $this->user->all();
        $posts = $this->post->all();

        return view('admin.comments.post', compact(
            'comments',
            'recipes',
            'wishlist',
            'users',
            'posts'
        ));
    }

    public function deleteComment(Request $request, $id)
    {
        $comment = $this->comment->findOrFail($id);
        $ownerId = $comment->commentable_id;
        $this->comment->destroy($id);
        if ($request->comment_type == 'recipe') {
            $recipe = $this->recipe->findOrfail($ownerId);
            if ($comment->user_id !== $recipe->user->id) {
                $currentPoint = $recipe->user->star_num;
                $newPoint = $currentPoint - config('manual.star_num.be_commented');
                $this->user->getNewestStarPoint($recipe->user->id, $newPoint);
            }
        } else {
            $post = $this->post->findOrfail($ownerId);
            if ($comment->user_id !== $post->user->id) {
                $currentPoint = $post->user->star_num;
                $newPoint = $currentPoint - config('manual.star_num.be_commented');
                $this->user->getNewestStarPoint($post->user->id, $newPoint);
            }
        }
        $notification = [
            'message' => __('Delete comment successfully!'),
            'alert-type' => 'warning',
        ];

        return redirect()->back()->with($notification);
    }
}
