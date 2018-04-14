<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $table = 'user_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'image_path',
    ];

    /**
     * The attributes that are visible.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'user_id',
        'image_path',
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

    public function image() {
        $this->belongsTo('App\Http\Models\Image');
    }
}
