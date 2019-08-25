<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/**
* Home
*/

Route::get('/', [
    
    'uses' => '\Facebook\Http\Controllers\HomeController@index',
    'as' => 'home'
    
]);


/**
* Authentification
*/

Route::get('/signup', [
    
    'uses' => '\Facebook\Http\Controllers\AuthController@getSignup',
    'as' => 'auth.signup',
    'middleware' => ['guest']
    
]);

Route::post('/signup', [
    
    'uses' => '\Facebook\Http\Controllers\AuthController@postSignup',
    'middleware' => ['guest']
    
]);

Route::get('/signin', [
    
    'uses' => '\Facebook\Http\Controllers\AuthController@getSignin',
    'as' => 'auth.signin',
    'middleware' => ['guest']
    
]);

Route::post('/signin', [
    
    'uses' => '\Facebook\Http\Controllers\AuthController@postSignin',
    'middleware' => ['guest']
    
]);

Route::get('/signout', [
    
    'uses' => '\Facebook\Http\Controllers\AuthController@getSignout',
    'as' => 'auth.signout'
    
]);

Route::get('/group', [

    'uses' => '\Facebook\Http\Controllers\GroupController@getGroup',
    'as' => 'group.index',
    'middleware' => ['auth']

]);

Route::get('/group/create', [

    'uses' => '\Facebook\Http\Controllers\GroupController@createGroup',
    'as' => 'group.create',
    'middleware' => ['auth']

]);

Route::post('/group/create/new', [

    'uses' => '\Facebook\Http\Controllers\GroupController@newGroup',
    'as' => 'group.new',
    'middleware' => ['auth']

]);

Route::get('/group/join/{groupId}', [

    'uses' => '\Facebook\Http\Controllers\GroupController@joinGroup',
    'as' => 'group.join',
    'middleware' => ['auth']

]);

Route::get('/group/page/{groupId}', [

    'uses' => '\Facebook\Http\Controllers\GroupController@pageGroup',
    'as' => 'group.page',
    'middleware' => ['auth']

]);



/**
* Search
*/

Route::get('/search', [
    
    'uses' => '\Facebook\Http\Controllers\SearchController@getResults',
    'as' => 'search.results'
    
]);


/**
* User Profile
*/

Route::get('/user/{username}', [
    
    'uses' => '\Facebook\Http\Controllers\ProfileController@getProfile',
    'as' => 'profile.index'
    
]);

Route::get('/profile/edit', [
    
    'uses' => '\Facebook\Http\Controllers\ProfileController@getEdit',
    'as' => 'profile.edit',
    'middleware' => ['auth']
    
]);

Route::post('/profile/edit', [
    
    'uses' => '\Facebook\Http\Controllers\ProfileController@postEdit',
    'as' => 'profile.edit',
    'middleware' => ['auth']
    
]);


/**
* Friends
*/

Route::get('/friends', [
    
    'uses' => '\Facebook\Http\Controllers\FriendController@getIndex',
    'as' => 'friends.index',
    'middleware' => ['auth']
    
]);


Route::get('/friends/add/{username}', [
    
    'uses' => '\Facebook\Http\Controllers\FriendController@getAdd',
    'as' => 'friend.add',
    'middleware' => ['auth']
    
]);

Route::get('/friends/accept/{username}', [
    
    'uses' => '\Facebook\Http\Controllers\FriendController@getAccept',
    'as' => 'friend.accept',
    'middleware' => ['auth']
    
]);

Route::get('/friends/deny/{username}', [

    'uses' => '\Facebook\Http\Controllers\FriendController@getDeny',
    'as' => 'friend.deny',
    'middleware' => ['auth']

]);

Route::post('/friends/delete/{username}', [
    
    'uses' => '\Facebook\Http\Controllers\FriendController@postDelete',
    'as' => 'friend.delete',
    'middleware' => ['auth']
    
]);


/**
* Statuses
*/

Route::post('/status', [
    
    'uses' => '\Facebook\Http\Controllers\StatusController@postStatus',
    'as' => 'status.post',
    'middleware' => ['auth']
    
]);

Route::post('/status/{statusId}/reply', [
    
    'uses' => '\Facebook\Http\Controllers\StatusController@postReply',
    'as' => 'status.reply',
    'middleware' => ['auth']
    
]);

Route::get('/status/{statusId}/like', [
    
    'uses' => '\Facebook\Http\Controllers\StatusController@getLike',
    'as' => 'status.like',
    'middleware' => ['auth']
    
]);
