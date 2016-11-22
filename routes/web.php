<?php


use GrahamCampbell\GitHub\Facades\GitHub;
use MagicMirror\Module;
use MagicMirror\Tag;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();
Route::get('login', 'AuthController@redirectToProvider');
Route::get('auth/github', 'AuthController@redirectToProvider');
Route::get('auth/github/callback', 'AuthController@handleProviderCallback');
Route::post('logout', 'AuthController@logout');

Route::resource('module', 'ModuleController');
Route::get('/module/{module}', function(Module $module) {
    return redirect("/module/" . $module->id . "/" . $module->slug);
});
Route::get('/module/{module}/{file?}', 'ModuleController@show');
Route::get('/modules', 'ModuleController@index');

// Add file routes.
Route::post('/upload', 'FileController@upload');
Route::get('/file/{file}', 'FileController@fetch');
Route::get('/image/{file}/{size?}/{quality?}', 'FileController@image');

Route::get('/', function() {

    // dd('Bearer ' . $accessToken);

    // dd(Auth::user()->repositories());

    return view('welcome');
});


Route::get('test', function() {
    
    return Tag::getOrCreate(['whoot', 'foo', 'bar','whutt','works']);

});