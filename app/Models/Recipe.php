<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\RecipeRelation;
use Laravel\Scout\Searchable;

class Recipe extends Model
{
    use RecipeRelation;
    use Searchable;

    protected $fillable = [
        'name',
        'user_id',
        'recipe_number',
        'estimate_time',
        'description',
        'image',
        'video_link',
        'rating_point',
        'level_id',
        'people_number',
        'status',
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return array(
            'id' => $array['id'],
            'name' => $array['name'],
            'description' => $array['description'],
            'user_id' => $array['user_id']
        );
    }
}
