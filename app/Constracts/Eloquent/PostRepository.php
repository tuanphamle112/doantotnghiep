<?php

namespace App\Constracts\Eloquent;

use App\Constracts\Eloquent\BaseRepository;

interface PostRepository extends BaseRepository
{
    public function getNewestPostForHomepage();

    public function getPopularPostForHomepage();

    public function getAllPostActive($with = [], $paginate);

    public function getAllPostsOfOneUser($paginate, $userId, $with = []);

    public function getAllPostsDesc($paginate, $with = []);
}
