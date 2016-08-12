<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('tags/{slug}/posts', [
    'uses' => 'PostsController@index',
    'as' => 'tags.posts.index',
]);
Route::resource('posts', 'PostsController');

Route::resource('posts.comments', 'CommentsController', [
    'only' => ['index', 'store']
]);
Route::resource('comments', 'CommentsController', [
    'only' => ['update', 'destroy']
]);

Auth::routes();

Route::get('/home', 'HomeController@index');
