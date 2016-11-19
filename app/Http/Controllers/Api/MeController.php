<?php

namespace MagicMirror\Http\Controllers\Api;

use Illuminate\Http\Request;
use MagicMirror\Http\Controllers\Api\ApiController;
use Auth;
use MagicMirror\Module;

class MeController extends ApiController
{
    /** 
    * Returns the object of the current user.
    *
    * @return array
    */
    public function me() {
        return Auth::user();
    }

    /** 
    * Returns all the repositories by the current userr.
    *
    * @return array
    */
    public function repositories() {
        
        $myModules = Auth::user()->modules->keyBy('github_name')->toArray();    

        Auth::user()->nonForkedRepositories()
            ->sortByDesc(function ($repository) {
                return $repository['created_at'];
            })
            ->map(function($repository) use(&$repositories, $myModules) {
                if (array_key_exists($repository['name'], $myModules)) {
                    $repository['magicmirror_id'] = $myModules[$repository['name']]['id'];
                }
                $repositories[] = $repository;           
        });

        return $repositories;
    }
}
