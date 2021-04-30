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
Route::get('/', 'Welcome@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('read-post/{id}', 'Welcome@post')->name('read-post');
Route::get('like-post/{id}', 'Welcome@like')->name('like-post');


Route::post('create-post', 'Post@save')->name('create-post');
Route::post('update-post/{id}', 'Post@update')->name('update-post');
Route::get('view-post/{id}', 'Post@show')->name('show-post');
Route::delete('delete-post/{id}', 'Post@destroy')->name('delete-post');