<?php

namespace MagicMirror\Http\Controllers\Api;

use Illuminate\Http\Request;
use MagicMirror\Http\Controllers\Api\ApiController;
use Auth;
use MagicMirror\Module;
use MagicMirror\Tag;
use GrahamCampbell\GitHub\Facades\GitHub;

class ModuleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Module::all()->each(function($module) {
            if (!Auth::guard('api')->guest()) {
                $module->addLikedForUser(Auth::guard('api')->user());
            }
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::guard('api')->user()->admin && $request->get('github_name') !== Auth::guard('api')->user()->github_name) {
            abort(403);
        }

        $this->validate($request, [
            'github_user' => 'required',
            'github_name' => 'required',
            'name' => 'required|unique:modules|max:50',
            'description' => 'required|max:256',
            'link' => 'url',
            'category_id' => 'required',
        ]);

        $module = Module::create($request->all());
        
        $tagIDs = Tag::getOrCreate($request->get('tags', []))->pluck('id')->toArray();
        $module->tags()->sync($tagIDs);

        $module->addLikedForUser(Auth::guard('api')->user());

        return $module;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        $module->addLikedForUser(Auth::guard('api')->user());

        return $module;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
        if (!Auth::guard('api')->user()->admin && $request->get('github_name') !== Auth::guard('api')->user()->github_name) {
            abort(403);
        }

        $this->validate($request, [
            'github_user' => 'required',
            'github_name' => 'required',
            'name' => 'required|unique:modules,name,' .$module->id. '|max:50',
            'description' => 'required|max:256',
            'link' => 'url',
            'category_id' => 'required',
        ]);

        $module->update($request->all());

        $tagIDs = Tag::getOrCreate($request->get('tags', []))->pluck('id')->toArray();
        $module->tags()->sync($tagIDs);

        $module->addLikedForUser(Auth::guard('api')->user());

        return $module;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Return the repository data.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function repository(Module $module)
    {
        return $module->repository;
    }

    /**
     * Return the readme of the module.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function readme(Module $module)
    {
        $url = $module->readmeUrl;

        if ($url) {
            //return \Cache::remember('Readme-'.$module->id, 5, function () use ($url) {
                return file_get_contents($url);
            //});
        }

        abort(404);
    }

    /**
     * Set the liked state of a modle by a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function liked(Request $request, Module $module)
    {
        if ($request->get('likes')) {
            $module->likes()->attach(Auth::user()->id);
        } else {
            $module->likes()->detach(Auth::user()->id);
        }

        return $module;
    }
}


