<?php

Route::get('/', function () {
    return view('welcome');
});

Route::resource('posts', 'PostsController');

Auth::routes();

Route::get('/home', 'HomeController@index');
