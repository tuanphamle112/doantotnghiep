<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Relations\UserRelation;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable;
    use UserRelation;
    use Searchable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'avatar',
        'permission',
        'gender',
        'total_point',
        'star_num',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return array(
            'id' => $array['id'],
            'name' => $array['name'],
            'email' => $array['email'],
            'phone' => $array['phone'],
            'address' => $array['address']
        );
    }
}
