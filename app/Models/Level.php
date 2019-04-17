<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\LevelRelation;

class Level extends Model
{
    use LevelRelation;
    
    protected $fillable = [
        'name',
        'description',
    ];
}
