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

    public function getNewestPostForHomepage()
    {
        return $this->model->take(6)->orderBy('id', 'DESC')->get();
    }

    public function getPopularPostForHomepage() 
    {
        return $this->model->take(4)->orderBy('id', 'ASC')->get();
    }
}
