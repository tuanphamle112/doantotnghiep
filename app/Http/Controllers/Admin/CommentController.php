<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Constracts\Eloquent\CommentRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Helpers\Helper;
use Auth;

class CommentController extends Controller
{
    protected $comment;
    protected $recipe;

    public function __construct(
        CommentRepository $comment,
        RecipeRepository $recipe
        ) {
        $this->comment = $comment;
        $this->recipe = $recipe;
    }

    public function index() {

        $comments = $this->comment->paginate(config('manual.pagination.comment'));

        return view('admin.comments.index', compact('comments'));
    }

    public function deleteComment($id)
    {
        $comment = $this->comment->findOrFail($id);
        
        $this->comment->destroy($id);

        $notification = [
            'message' => __('Delete comment successfully!'),
            'alert-type' => 'warning',
        ];

        return redirect()->back()->with($notification);
    }

}
