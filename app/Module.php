<?php

namespace MagicMirror;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GrahamCampbell\GitHub\Facades\GitHub;
use Auth;

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

    protected $appends = ['slug', 'url', 'uri', 'github_url', 'tags', 'likes'];

    protected $hidden = ['deleted_at'];

    protected $with = ['category'];

    private $likedUser = null;

    public function user() {
        return $this->belongsTo('MagicMirror\User', 'github_user', 'github_user');
    }

    public function category() {
        return $this->belongsTo('MagicMirror\Category');
    }

    public function tags() {
        return $this->belongsToMany('MagicMirror\Tag');
    } 

    public function likes() {
        return $this->belongsToMany('MagicMirror\User', 'likes');
    }

    public function getSlugAttribute() {
        return str_slug($this->name);
    }

    public function getUriAttribute() {
        return '/module/' . $this->id . '/' . $this->slug;
    }

    public function getUrlAttribute() {
        return url($this->uri);
    }

    public function getTagsAttribute() {
        return $this->tags()->pluck('name')->toArray();
    }

    public function getLikesAttribute() {
        return $this->likes()->count();
    }

    public function getLikedAttribute() {
        if ($this->likedUser && $this->likes()->where('id','=',$this->likedUser->id)->first()) {
            return true;
        }

        return false;
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

    public function addLikedForUser(User $user) {
        if ($user) {
            $this->likedUser = $user;
            $this->appends[] = 'liked';
        }
    }

}
