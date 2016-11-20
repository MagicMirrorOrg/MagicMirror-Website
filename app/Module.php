<?php

namespace MagicMirror;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GrahamCampbell\GitHub\Facades\GitHub;

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

    public function getRepositoryAttribute() {
        return GitHub::connection('application')->repo()->show($this->github_user, $this->github_name);
    }

    public function getReadmeUrlAttribute() {
        $readmeData = GitHub::connection('application')->repo()->contents()->readme($this->github_user, $this->github_name);
        if ($readmeData) {
            return $readmeData['download_url'];
        }
        return false; 
    }

}
