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
Route::auth();
Route::get('/', 'HomeController@index');
Route::get('avatar/{file}', ['as' => 'account.avatar' ,'uses' => 'UserController@showAvatar']);
Route::get('/search', 'HomeController@search');

Route::group(['prefix' => 'browse'], function(){
	Route::get('/', 'BrowseController@index');
	Route::get('/{category}', 'BrowseController@category');
	Route::post('/category', 'BrowseController@suggest');
});

Route::group(['prefix' => 'albums'], function (){
	Route::get('/', 'AlbumsController@index');
	Route::put('/create','AlbumsController@create_album');
	Route::post('/update/{album}', 'AlbumsController@update');
	Route::get('/thumbnail/{file}', ['as' => 'album.thumbnail', 'uses' => 'AlbumsController@showThumbnail']);
	Route::get('/{albumName}', 'AlbumsController@displayAlbum');
	Route::delete('/purge/{album}', 'AlbumsController@purge');
});
Route::group(['prefix' => 'images'], function(){
	Route::get('/', 'ImagesController@index');
	Route::get('/display/{album_id}/{file}', ['as' => 'image.serve', 'uses' => 'HomeController@serve']);//Public Serve
	Route::get('/view/{name}', 'ImagesController@view');
	Route::get('/upload', 'ImagesController@upload');
	Route::post('/like/{image}', 'ImagesController@like_image');
	Route::post('/upload', 'ImagesController@save_image');
	Route::post('/update/{image}', 'ImagesController@update');
	//Route::post('/rename', 'ImagesController@rename');////////////TEst
	Route::post('/report', 'ImagesController@report');
	Route::get('/{name?}', 'HomeController@view');
	Route::post('/comments/submit', 'ImagesController@submit_comment');
	Route::delete('/purge/{image}', 'ImagesController@delete');
});

Route::get('/about', function(){
	return view('about');
});

Route::group(['prefix' => 'account'], function (){
	Route::get('/', 'AccountController@index');
	Route::get('/social', 'AccountController@social');
	Route::post('/social', 'AccountController@social_update');
	Route::get('/avatar', 'AccountController@avatar');
	Route::post('/avatar', 'AccountController@update_avatar');
	Route::get('/edit', 'AccountController@edit');
	Route::post('/edit', 'AccountController@edit_details');
	Route::get('/purge', 'AccountController@purge');
	Route::delete('/purge/{user}', 'AccountController@delete');
	Route::get('/password', 'AccountController@password');
	Route::post('/password', 'AccountController@update_password');
});

Route::group(['prefix' => 'user'], function(){
	Route::get('/password/reset', 'Auth\PasswordController@reset');
	Route::get('/{user}', 'UserController@index');
});
Route::group(['prefix' => 'admin'], function(){
	Route::get('/', 'AdminController@index');
	Route::get('/users', 'AdminController@users');
	Route::get('/users/{user}', 'AdminController@view_user');
	Route::get('/albums', 'AdminController@albums');
	Route::get('/images', 'AdminController@images');
	Route::get('/images/{image}', 'AdminController@view_image');
	Route::get('/reports', 'AdminController@reports');
	Route::post('update/{user}', 'AdminController@update_user');
	Route::post('suspend/{user}', 'AdminController@suspend_user');
	Route::post('reset/{user}', 'AdminController@reset_password');
});

