<?php

namespace App\Http\Controllers\Frontend;

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

    public function storeComment(Request $request, $id)
    {
        $recipe = $this->recipe->findOrfail($id);
        $userName = Auth::user()->name;
        $userImage = Auth::user()->avatar;
        $avatar = asset('uploads/avatars/' . $userImage);
        $userCommentId = Auth::user()->id;

        $comment = $recipe->comments()->create([
            'content' => $request->comment,
            'commentable_id' => $id,
            'user_id' => $userCommentId,
        ]);
        $createAt = Helper::formatDayMonthYearTime($comment->created_at);
        $deleteUrl = route('comment.delete', $comment->id);

        return response()->json([
            'name' => $userName,
            'avatar' => $avatar,
            'content' => $request->comment,
            'userLink' => $request->userLink,
            'createAt' => $createAt,
            'deleteUrl' => $deleteUrl,
        ]);
    }
    public function editComment(Request $request, $id)
    {
        $comment = $this->comment->findOrFail($id);
        $content = [
            'content' => $request->content_edited,
        ];
        $this->comment->update($id, $content);

        $notification = [
            'message' => __('Update comment successfully!'),
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);

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
