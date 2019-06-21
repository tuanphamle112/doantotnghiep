<?php

namespace App\Constracts\Eloquent;

use App\Constracts\Eloquent\BaseRepository;

interface CommentRepository extends BaseRepository
{
    public function getAllRecipeComment($paginate, $with = []);

    public function getAllPostComment($paginate, $with = []);

}
