<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\PostRelation;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use PostRelation;
    use Searchable;

    protected $fillable = [
        'title',
        'image',
        'description',
        'content',
        'user_id',
        'status',
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return array(
            'id' => $array['id'],
            'title' => $array['title'],
            'description' => $array['description'],
            'user_id' => $array['user_id']
        );
    }
}
