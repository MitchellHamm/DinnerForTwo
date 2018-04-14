<?php

namespace App\Http\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Cmgmyr\Messenger\Traits\Messagable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    // Use the message application and make the user messagable
    use Messagable;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'city',
        'age',
        'bio',
        'firstName',
        'image_slug',
        'api_token',
    ];

    /**
     * The attributes that are visible.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'email',
        'firstName',
        'city',
        'age',
        'bio',
        'image_slug',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    public function user() {
        return $this->belongsTo('App\Http\Models\User');
    }

    public function images() {
        return $this->hasMany('App\Http\Models\Image');
    }

    public function availableUser() {
        return $this->hasOne('App\Http\Models\AvailableUser');
    }

    public function sendPasswordResetNotification($token)
    {
        // TODO: Implement sendPasswordResetNotification() method.
    }
}
