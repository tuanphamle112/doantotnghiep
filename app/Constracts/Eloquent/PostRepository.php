<?php

namespace App\Constracts\Eloquent;

use App\Constracts\Eloquent\BaseRepository;

interface PostRepository extends BaseRepository
{
    public function getNewestPostForHomepage();

    public function getPopularPostForHomepage();
}
