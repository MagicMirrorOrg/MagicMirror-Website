<?php

namespace MagicMirror;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The github instance. Don't use it directly.
     *
     * @var GithubClient
     */
    private $github;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'github_id', 'avatar', 'github_token', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'github_token', 'api_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'admin' => 'boolean',
    ];

    /**
    * Returns a collection of non forked repositories ordered by update time.
    * 
    * @return Collection;
    */
    public function repositories()
    {
        $repositories = array();
        collect($this->githubClient()->api('current_user')->repositories())
            ->filter(function($repository) {
                return !$repository['fork'];
            })
            ->sortByDesc(function ($repository) {
                return $repository['updated_at'];
            })
            ->map(function($repository) use(&$repositories) {
                $repositories[] = $repository;
            });

        return $repositories;
    }

    /**
    * Returns an authenticated github client.
    * 
    * @return Github\Client;
    */
    private function githubClient() {
        if (!$this->github) {
            $this->github = new \Github\Client();
            $this->github->authenticate($this->github_token, 'http_token');
        }

        return $this->github;
    }

}
