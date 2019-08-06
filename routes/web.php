<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user', 'UserController@index');

Route::get('/bbs', 'BbsController@index');

Route::post('/bbs', 'BbsController@create');

Route::get('github', 'Github\GithubController@top')->name('github_login');
Route::post('github/issue', 'Github\GithubController@createIssue');
Route::get('login/github', 'Auth\LoginController@redirectToProvider');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');

Route::post('user', 'User\UserController@updateUser');

Route::get('/', 'HomeController@index')->name('top');

Route::post('/upload', 'HomeController@upload')->name('upload');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/logout', 'UserController@logout')->name('logout');

Route::get('/form', 'HomeController@form')->name('form'); //投稿フォーム