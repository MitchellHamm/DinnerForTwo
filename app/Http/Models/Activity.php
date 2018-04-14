<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    protected $table = 'activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * The attributes that are visible.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'activity_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function image() {
        $this->belongsTo('App\Http\Models\Activity');
    }
}
