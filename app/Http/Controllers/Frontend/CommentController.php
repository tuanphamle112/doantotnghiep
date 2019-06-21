<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Constracts\Eloquent\CommentRepository;
use App\Constracts\Eloquent\RecipeRepository;
use App\Constracts\Eloquent\PostRepository;
use App\Constracts\Eloquent\UserRepository;
use App\Helpers\Helper;
use Auth;

class CommentController extends Controller
{
    protected $comment;
    protected $recipe;
    protected $post;
    protected $user;

    public function __construct(
        CommentRepository $comment,
        RecipeRepository $recipe,
        PostRepository $post,
        UserRepository $user
        ) {
        $this->comment = $comment;
        $this->recipe = $recipe;
        $this->post = $post;
        $this->user = $user;
    }

    public function storeComment(Request $request, $id)
    {
        $userName = Auth::user()->name;
        $userImage = Auth::user()->avatar;
        $avatar = asset('uploads/avatars/' . $userImage);
        $userCommentId = Auth::user()->id;
        $recipe = $this->recipe->findOrfail($id);
        $post = $this->post->findOrfail($id);
        if ($request->commentType == 'recipe') {
            $currentPoint = $recipe->user->star_num;
            $newPoint = $currentPoint + config('manual.star_num.be_commented');
            $comment = $recipe->comments()->create([
                'content' => $request->comment,
                'commentable_id' => $id,
                'user_id' => $userCommentId,
            ]);
            $this->user->getNewestStarPoint($recipe->user->id, $newPoint);
        } else {
            $currentPoint = $post->user->star_num;
            $newPoint = $currentPoint + config('manual.star_num.be_commented');
            $comment = $post->comments()->create([
                'content' => $request->comment,
                'commentable_id' => $id,
                'user_id' => $userCommentId,
            ]);
            $this->user->getNewestStarPoint($post->user->id, $newPoint);
        }
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
