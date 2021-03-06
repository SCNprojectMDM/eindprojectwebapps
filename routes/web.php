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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/HELLO', function () {
//    return "<h1>TESTER</h1>";
//});
//

// hier worden de paginas verbonden met de benodigde fucnties

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

Route::resource('posts', 'PostsController');

//Route::get('/users/{id}', function ($id) {
//    return $id;
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
