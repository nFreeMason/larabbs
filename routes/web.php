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

switch (request()->server('HTTP_HOST'))
{
	case 'larabbs.cn':
	{
		App::setLocale('zh-CN');
		break;
	}
	case 'larabbs.com':
	{
		App::setLocale('en');
		break;
	}
	case 'larabbs.jp':
	{
		App::setLocale('ja-jp');
		break;
	}
}

Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

Route::resource('categories','CategoriesController',['only'=>['show']]);

Route::resource('users','UsersController',['only'=>['show','update','edit']]);
Route::match(['put','patch'],'users/{user}','UsersController@update')->name('users.update');
Route::get('users/{user}/edit','UsersController@edit')->name('users.edit');

Route::get('/', 'PagesController@root')->name('root');

Auth::routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

/*
|--------------------------------------------------------------------------
| 测试路由
|--------------------------------------------------------------------------
|
| 测试
|
*/
Route::any('test','Test\Test@index')->name('test.index');

//Route::any('test','Test\Test@index')->name('test.index');

//Route::resource('test/users','Test\Test');

Route::get('test/{user}','Test\Test@show')->name('test.show');
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::get('topics/{topic}/{slug?}','TopicsController@show')->name('topics.show');
Route::resource('replies', 'RepliesController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);