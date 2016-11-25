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

// Add file routes.
Route::post('/upload', 'FileController@upload');
Route::get('/file/{file}', 'FileController@fetch');
Route::get('/image/{file}/{size?}/{quality?}', 'FileController@image');

// Add a catch all route to load the Vue frontend app.
Route::any( '{catchall}', function ( $page ) {
    return view('layouts.app');
} )->where('catchall', '(.*)');