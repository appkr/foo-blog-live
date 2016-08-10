<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('tags/{slug}/posts', [
    'uses' => 'PostsController@index',
    'as' => 'tags.posts.index',
]);
Route::resource('posts', 'PostsController');

Auth::routes();

Route::get('/home', 'HomeController@index');
