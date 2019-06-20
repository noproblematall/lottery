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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Admin
Route::get('admin','AdminController@index')->name('admin.index');
Route::get('admin/user','AdminController@user')->name('admin.user');
Route::post('admin/add-user', 'AdminController@add_user')->name('admin.add_user');
Route::get('admin/edit-balance', 'AdminController@edit_balance')->name('admin.edit_balance');
Route::get('admin/user-edit/{id}', 'AdminController@user_edit')->name('admin.user_edit');
Route::get('admin/user-delete/{id}', 'AdminController@user_delete')->name('admin.user_delete');
Route::post('admin/user-save', 'AdminController@user_save')->name('admin.user_save');
Route::get('admin/setting', 'AdminController@setting')->name('setting');
Route::post('admin/setting','AdminController@admin_setting')->name('admin_setting');
Route::get('admin/user-block','AdminController@user_block')->name('user_block');
Route::get('admin/win-number','AdminController@win_number')->name('admin.win_number');
Route::get('admin/add-win','AdminController@add_win')->name('admin.add_win');
Route::post('admin/win-search','AdminController@win_search')->name('admin.win_search');
// Route::group([
//     'middleware' => 'super',
//     'prefix' => 'admin'
// ], function ($router) {
    
// });


// User
Route::get('/', 'HomeController@index')->name('home');



