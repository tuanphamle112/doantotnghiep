<?php

namespace App\Constracts\Eloquent;

use App\Constracts\Eloquent\BaseRepository;

interface UserRepository extends BaseRepository
{
    public function getFeatureMember($with = [], $select = ['*']);

    public function getNewestStarPoint($id, $point = 0);
}
