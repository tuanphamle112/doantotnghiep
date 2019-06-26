<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\GiftRelation;

class Gift extends Model
{
    use GiftRelation;
    
    protected $fillable = [
        'name',
        'image',
        'description',
        'quantity'
    ];
}
