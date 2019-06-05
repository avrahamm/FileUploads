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

// Laravel out of the box authentication routes.
Auth::routes();

Route::get('/', 'UploadController@create')->name('root');
Route::get('/home', 'UploadController@create')->name('home');

// Setting relevant uploads routes.
Route::resource('uploads', 'UploadController')->except(['show','edit','update','destroy']);
Route::get('uploads/{uuid}/download/{targetName}', 'UploadController@download')->name('uploads.download');

