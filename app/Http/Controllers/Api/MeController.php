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
        
        $repositoryCollection = Auth::user()->nonForkedRepositories()
            ->sortByDesc(function ($repository) {
                return $repository['created_at'];
            });


        // Find all exsisting modules from the repository collection.
        $ids = $repositoryCollection->pluck('html_url')->toArray();
        $knownModules = [];
        Module::whereIn('github_url', $ids)->get()->map(function($module) use(&$knownModules) {
            $knownModules[$module->github_url] = $module->id;
        });
    

        // Create a simple array and add magicmirror_ids if we already know the module.
        $repositories = [];
        $repositoryCollection->map(function($repository) use(&$repositories, $knownModules) {
                if (array_key_exists('html_url', $repository) && array_key_exists($repository['html_url'], $knownModules)) {
                    $repository['magicmirror_id'] = $knownModules[$repository['html_url']];
                }
                $repositories[] = $repository;
                
        });

        return $repositories;
    }
}
