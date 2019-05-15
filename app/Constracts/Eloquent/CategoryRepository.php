<?php

namespace App\Constracts\Eloquent;

use App\Constracts\Eloquent\BaseRepository;

interface CategoryRepository extends BaseRepository
{
    public function getParentCategoriesPaginate($paginate);

    public function getChildrenCategories($parentId);

    public function getOptionParentCategories();

    public function getAllParentCategories();

    public function getParentCategoryByLink($link);

    public function getSubCategoryByParentId($parentId);

    public function getSubCategoryByLink($link, $parentId);

    public function getAllRecipeIdByCategory($listCateId);

    public function getRecipeBySubCategory($parentId, $subcateId);
}
