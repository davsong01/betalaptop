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
Route::get('/test', 'HomeController@test')->name('shop');

Auth::routes();
// Admin only routes

Route::middleware(['auth', 'isAdmin'])->group (function() {
    Route::post('/users/validate/email', 'UserController@validateEmail')->name('users.validate.email');
    Route::post('/users/validate/username', 'UserController@validateUsername')->name('users.validate.username');
    Route::resource('users', 'UserController');
    Route::get('wallethistory/{id}', 'UserController@getWalletHistory')->name('wallethistory');
    Route::get('pending-mails', 'EmailController@index')->name('pending.mails');
    Route::post('retry/pending/mails', 'EmailController@retryAll')->name('retry.pending.mails');
    Route::post('retry/single/{id}/mail', 'EmailController@retrySingle')->name('retry.single.pending.mail');
    Route::resource('settings', 'SettingController');
    Route::get('transactions/proof-of-payment/all', 'TransactionsController@allProofOfPayment')->name('transactions.all.proofOfPayment');
    Route::put('transactions/proof-of-payment/{id}/reject', 'TransactionsController@rejectProofOfPayment')->name('transaction.reject.proofOfPayment');
    Route::put('transactions/proof-of-payment/{id}/accept', 'TransactionsController@acceptProofOfPayment')->name('transaction.accept.proofOfPayment');

});

// General Authenticated routes
Route::middleware(['auth'])->group (function() {
    Route::get('/account', 'DashboardController@index')->name('account');
    Route::get('/profile', 'DashboardController@profile')->name('profile');
    Route::post('/profile', 'DashboardController@saveProfile')->name('saveprofile');
    Route::resource('transactions', 'TransactionsController');
    Route::resource('wallet', 'WalletController');
    Route::get('payments', 'PaymentController@allTransactions')->name('payments.index');
    Route::post('/downline/validate/email', 'DownlineController@validateEmail')->name('downline.validate.email');
    Route::post('/downline/validate/username', 'DownlineController@validateUsername')->name('downline.validate.username');
    Route::resource('downline', 'DownlineController');
    Route::get('binarytree/{id}', 'UserController@binaryTree')->name('binarytree');

    Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay');
    Route::get('/payment/callback', 'PaymentController@handleGatewayCallback')->name('handle');
    Route::post('transactions/validate/username-or-email', 'TransactionsController@validateUsernameOrEmail')
        ->name('transactions.validate.usernameOrEmail');
    Route::post('transactions/transfer-fund', 'TransactionsController@transferFund')->name('transactions.transferFund');
    Route::post('transactions/proof-of-payment', 'TransactionsController@uploadPOP')->name('transactions.proofOfPayment');
    Route::get('transactions/proof-of-payment/me', 'TransactionsController@meProofOfPayment')->name('transactions.me.proofOfPayment');
});
