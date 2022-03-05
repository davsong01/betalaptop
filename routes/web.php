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
    Route::resource('settings', 'SettingController');
    Route::get('transactions/proof-of-payment/all', 'TransactionsController@allProofOfPayment')->name('transactions.all.proofOfPayment');

});

// General Authenticated routes
Route::middleware(['auth'])->group (function() {
    Route::get('/account', 'DashboardController@index')->name('account');
    Route::get('/profile', 'DashboardController@profile')->name('profile');
    Route::post('/profile', 'DashboardController@saveProfile')->name('saveprofile');
    Route::resource('transactions', 'TransactionsController');
    Route::resource('wallet', 'WalletController');
    Route::get('payments', 'PaymentController@allTransactions')->name('payments.index');
    Route::resource('downline', 'DownlineController');
    Route::get('binarytree/{id}', 'UserController@binaryTree')->name('binarytree');

    Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay');
    Route::get('/payment/callback', 'PaymentController@handleGatewayCallback')->name('handle');
    Route::post('transactions/validate/username-or-email', 'TransactionsController@validateUsernameOrEmail')
        ->name('transactions.validate.usernameOrEmail');
    Route::post('transactions/transfer-fund', 'TransactionsController@transferFund')->name('transactions.transferFund');
    Route::post('transactions/proof-of-payment', 'TransactionsController@uploadPOP')->name('transactions.proofOfPayment');
    Route::get('transactions/proof-of-payment/me', 'TransactionsController@meProofOfPayment')->name('transactions.me.proofOfPayment');
    Route::put('transactions/proof-of-payment/{id}/reject', 'TransactionsController@rejectProofOfPayment')->name('transaction.reject.proofOfPayment');
    Route::put('transactions/proof-of-payment/{id}/accept', 'TransactionsController@acceptProofOfPayment')->name('transaction.accept.proofOfPayment');
});
