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
        'github_user', 'github_name', 'name', 'description', 'image', 'link', 'views'
    ];

    protected $appends = ['slug','url'];

    protected $hidden = ['deleted_at','user_id'];

    protected $with = ['user'];

    public function user() {
        return $this->belongsTo('MagicMirror\User');
    }

    public function getSlugAttribute() {
        return str_slug($this->name);
    }

    public function getUrlAttribute() {
        return url('module/' . $this->id . '/' . $this->slug);
    }



}
