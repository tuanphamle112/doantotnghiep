<?php

namespace App\Constracts\Eloquent;

use App\Constracts\Eloquent\BaseRepository;

interface CategoryRepository extends BaseRepository
{
    public function getParentCategoriesPaginate($paginate);

    public function getChildrenCategories($parent_id);

    public function getOptionParentCategories();

    public function getAllParentCategories();
}
