<?php

namespace MagicMirror;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'github_id', 'github_url', 'name', 'description', 'image', 'link', 'views', 'user_id'
    ];

}
