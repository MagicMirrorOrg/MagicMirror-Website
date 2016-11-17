<?php


use GrahamCampbell\GitHub\Facades\GitHub;

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

Route::get('/', function() {

    // dd('Bearer ' . $accessToken);

    // dd(Auth::user()->repositories());

    return view('welcome');
});
