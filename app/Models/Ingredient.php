<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\IngredientRelation;
use Laravel\Scout\Searchable;

class Ingredient extends Model
{
    use IngredientRelation;
    use Searchable;

    protected $fillable = [
        'name',
        'note',
        'recipe_id',
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return array(
            'id' => $array['id'],
            'name' => $array['name']
        );
    }
}
