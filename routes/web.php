<?php
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::resource('posts', 'PostController');
Route::get('posts', 'PostController@index')->name('posts.index');
Route::get('posts/{id}', 'PostController@show')->name('posts.show');
Route::get('your-posts', 'PostController@myposts')->name('posts.myposts');
Route::group(['middleware' => ['user']], function() {//after login routes
	Route::get('posts/create', 'PostController@create')->name('posts.create');
	Route::post('posts/store', 'PostController@store')->name('posts.store');
	Route::POST('posts/update/{id}', 'PostController@update')->name('posts.update');
	Route::get('posts/delete/{id}', 'PostController@destroy')->name('posts.destroy');
});


Route::get('/', 'PostController@myposts')->name('home');
Route::get('/home', 'PostController@myposts')->name('home_new');