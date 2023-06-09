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

Route::get('/', 'WelcomeController@index');

Route::middleware(['guest'])->group(function () {
    Auth::routes();
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('home')->group(function () {
        Route::get('/', 'HomeController@index');
    });

    Route::prefix('story')->group(function () {
        Route::get('create', 'StoryController@create');
        Route::post('store', 'StoryController@store');
        Route::get('edit/{story_slug}', 'StoryController@edit');
        Route::put('update/{id}', 'StoryController@update');
        Route::delete('/destroy/{id}','StoryController@destroy');
        Route::get('{story_slug}', 'StoryController@show');
    });

    Route::prefix('user')->group(function () {
        Route::get('bookmark/{user_slug}', 'UserController@bookmarks');
        Route::put('update/{id}', 'UserController@update');
        Route::delete('destroy/{id}', 'UserController@destroy');
        Route::get('{user_slug}', 'UserController@index');
    });

    Route::prefix('search')->group(function () {
        Route::get('/', 'SearchController@index');
    });

    Route::prefix('tag')->group(function () {
        Route::get('/', 'TagController@index');
        Route::get('{tag_slug}', 'TagController@index');
        Route::post('add', 'FollowingTagController@store');
        Route::delete('remove/{id}', 'FollowingTagController@destroy');
        
        Route::post('store', 'TagController@store');
        Route::delete('destroy/{id}', 'TagController@destroy');
    });

    Route::prefix('comment')->group(function () {
        Route::get('store', 'CommentController@store');
        Route::delete('destroy/{id}', 'CommentController@destroy');
        Route::put('update/{id}', 'CommentController@update');
    });

    Route::prefix('bookmark')->group(function () {
        Route::post('toggle/{id}', 'BookmarkController@toggle');
    });

    Route::prefix('follow')->group(function () {
        Route::post('add/', 'FollowController@store');
        Route::delete('remove/{id}', 'FollowController@destroy');
    });

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
