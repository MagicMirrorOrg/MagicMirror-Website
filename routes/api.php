<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("me", "Api\MeController@me")->middleware("auth:api");
Route::get("me/repositories", "Api\MeController@repositories")->middleware("auth:api");

Route::resource("category", "Api\CategoryController");
Route::resource("tag", "Api\TagController");
Route::get("tag/{tag}", "Api\TagController@index");

Route::resource("module", "Api\ModuleController");
Route::get("module/{module}/repository", "Api\ModuleController@repository");
Route::get("module/{module}/readme", "Api\ModuleController@readme");
Route::post("module/{module}/liked", "Api\ModuleController@liked")->middleware('auth:api');;