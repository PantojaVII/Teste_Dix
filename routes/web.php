<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
		Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
		Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
		Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
		Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);
		Route::get('posts', ['as' => 'pages.posts', 'uses' => 'App\Http\Controllers\PageController@posts']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::get('createUser', 'App\Http\Controllers\UserController@create')->name('user.create');
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	Route::post('/user', 'App\Http\Controllers\UserController@store')->name('user.store');
	
	
	Route::get('/postagens', [PostController::class, 'index'])->name('posts.index');
	Route::post('/cadastrar_postagem', [PostController::class, 'store'])->name('posts.store');
	Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
	Route::get('/editar/{id}', [PostController::class, 'editar'])->name('posts.editar');
	Route::put('/update/{id}', [PostController::class, 'update'])->name('posts.update');
	Route::delete('/deletePost/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
	Route::get('/noticias/search', [PostController::class, 'search'])->name('posts.search');


	


});



