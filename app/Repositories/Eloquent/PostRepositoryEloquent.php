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
        return $this->model
        ->take(3)
        ->orderBy('id', 'DESC')
        ->where('status', config('manual.post_status.Actived'))
        ->get();
    }

    public function getPopularPostForHomepage()
    {
        return $this->model->take(4)->orderBy('id', 'ASC')->get();
    }
    public function getAllPostActive($with = [], $paginate)
    {
        $posts = $this->model
        ->with($with)
        ->where('status', config('manual.post_status.Actived'))
        ->orderBy('id', 'DESC')
        ->paginate($paginate);

        return $posts;
    }

    public function getAllPostsOfOneUser($paginate, $userId, $with = [])
    {
        $posts = $this->model
        ->with($with)
        ->where('user_id', $userId)
        ->orderBy('id', 'DESC')
        ->paginate($paginate);

        return $posts;
    }

    public function getAllPostsDesc($paginate, $with = [])
    {
        $posts = $this->model
        ->with($with)
        ->orderBy('id', 'DESC')
        ->paginate($paginate);

        return $posts;
    }
}
