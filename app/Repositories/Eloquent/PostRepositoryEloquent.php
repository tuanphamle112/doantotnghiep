<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepositoryEloquent;
use App\Constracts\Eloquent\PostRepository;

use App\Models\Post;

class PostRepositoryEloquent extends BaseRepositoryEloquent implements PostRepository
{
    public $model;

    public function __construct(Post $post)
    {
        $this->model = $post;
    }

}
