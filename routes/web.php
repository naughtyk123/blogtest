<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
});

// public routs 
Route::get('/', 'FrontController@index')->name('/');
Route::get('register', 'FrontController@register')->name('register');
Route::post('attempt_register', 'FrontController@attempt_register')->name('attempt_register');

Route::get('login', 'FrontController@login')->name('login');
Route::post('attempt_login', 'FrontController@attempt_login')->name('attempt_login');

Route::get('reade-more/{id}', 'FrontController@reade_more')->name('reade-more');
Route::get('get_search_result', 'FrontController@get_search_result')->name('get_search_result');







// auth middleware
Route::group(['middleware' => ['auth']], function () {

    Route::get('add-post', 'PostController@index')->name('add-post');
    Route::post('add_post_record', 'PostController@add_post_record')->name('add_post_record');

    Route::post('uploads', 'Tinymce@uploads')->name('uploadstiny');
    Route::post('remove_tiny_image', 'Tinymce@remove_tiny_image')->name('remove_tiny_image');


    Route::post('delete_post', 'PostController@delete_post')->name('delete_post');
    Route::get('edite/{id}', 'PostController@edite')->name('edite');
    Route::post('edite_post_record', 'PostController@edite_post_record')->name('edite_post_record');

    Route::get('my-posts', 'PostController@my_posts')->name('my-posts');
});
// end



