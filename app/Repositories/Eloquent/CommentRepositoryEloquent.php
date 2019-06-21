<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepositoryEloquent;
use App\Constracts\Eloquent\CommentRepository;

use App\Models\Comment;

class CommentRepositoryEloquent extends BaseRepositoryEloquent implements CommentRepository
{
    public $model;

    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }

    public function getAllRecipeComment($paginate, $with = [])
    {
        return $this->model
        ->with($with)
        ->where('commentable_type', 'App\Models\Recipe')
        ->paginate($paginate);
    }

    public function getAllPostComment($paginate, $with = [])
    {
        return $this->model
        ->with($with)
        ->where('commentable_type', 'App\Models\Post')
        ->paginate($paginate);
    }
}
