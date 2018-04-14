<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class AvailableUser extends Model
{

    protected $table = 'available_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'activity_id',
        'city',
        'expires_at'
    ];

    /**
     * The attributes that are visible.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'user_id',
        'activity_id',
        'expires_at',
        'city',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function availableUser() {
        $this->belongsTo('App\Http\Models\AvailableUser');
    }

    public function user() {
        $this->belongsTo('App\Http\Models\User');
    }
}
