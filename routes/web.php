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

// Route::get('/', );
Route::get('/', 'HomeController@index')->name('shop');

Auth::routes();
// Admin only routes

Route::middleware(['auth'])->group (function() {
    Route::resource('users', 'UserController');
    Route::get('wallethistory/{id}', 'UserController@getWalletHistory')->name('wallethistory');
    Route::resource('transactions', 'Transactions');
    Route::resource('wallettransactions', 'WalletController');
    Route::resource('settings', 'SettingController');
    Route::get('binarytree/{id}', 'UserController@binaryTree')->name('binarytree');


});

// General Authenticated routes
Route::middleware(['auth'])->group (function() {
    Route::get('/account', 'DashboardController@index')->name('account');
    Route::get('/profile', 'DashboardController@profile')->name('profile');
    Route::post('/profile', 'DashboardController@saveProfile')->name('saveprofile');


});
