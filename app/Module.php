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
        'github_user', 'github_name', 'name', 'description', 'image', 'link', 'views', 'category_id'
    ];

    protected $appends = ['slug', 'url', 'github_url', 'tags'];

    protected $hidden = ['deleted_at', 'category_id'];

    protected $with = ['category'];

    public function user() {
        return $this->belongsTo('MagicMirror\User', 'github_user', 'github_user');
    }

    public function category() {
        return $this->belongsTo('MagicMirror\category');
    }

    public function tags() {
        return $this->belongsToMany('MagicMirror\Tag');
    } 

    public function getSlugAttribute() {
        return str_slug($this->name);
    }

    public function getUrlAttribute() {
        return url('module/' . $this->id . '/' . $this->slug);
    }

    public function getTagsAttribute() {
        return $this->tags()->pluck('name')->toArray();
    }

    public function getGithubUrlAttribute() {
        return url('https://github.com/' . $this->github_user . '/' . $this->github_name);
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
