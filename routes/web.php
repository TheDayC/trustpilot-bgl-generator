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

Auth::routes();

// Account Routes
Route::get('/account', 'AccountController@index')->name('account');
Route::post('/account/change-password', 'AccountController@changePassword')->name('changepassword');

// Payload routes
Route::get('/', 'PayloadController@index')->name('payload');
Route::get('/payload', function () { return redirect()->route('payload'); });
Route::post('/payload/manual', 'PayloadController@manual')->name('payload-manual');
Route::post('/payload/file', 'PayloadController@file')->name('payload-file');
Route::post('/payload/send', 'PayloadController@send')->name('payload-send');

// Generate Links
Route::get('/links', 'BGLController@index')->name('bgl');

// Admin
Route::get('/admin', 'AccountController@admin')->name('admin');
Route::post('/admin/change-roles', 'AccountController@changeRoles')->name('change-roles');