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
Route::get('forgot-password', ['as'	=>	'forgot-password','uses' =>	'Auth\LoginController@forgotPassword']);

Route::group(['middleware' => 'auth'], function () {
	Route::get('dashboard', 'HomeController@index')->name('dashboard');
	//phiếu thu
	Route::get('get-list-cash-receipt-voucher', 'CashReceiptVoucherController@getList')->name('get-list-cash-receipt-voucher');
	Route::get('get-group-object', 'CashReceiptVoucherController@getGroupObject');
	Route::resource('cash-receipt-voucher', 'CashReceiptVoucherController');
	//hết
	//phiếu chi
	Route::get('get-list-cash-payment-voucher', 'CashPaymentVoucherController@getList')->name('get-list-cash-payment-voucher');
	Route::resource('cash-payment-voucher', 'CashPaymentVoucherController');
	//hết
	//Giay báo có
	Route::get('get-list-credit-note', 'CreditNoteController@getList')->name('get-list-credit-note');
	Route::resource('credit-note', 'CreditNoteController');
	//hết
	//Giay báo có
	Route::get('get-list-standing-order', 'StandingOrderController@getList')->name('get-list-standing-order');
	Route::resource('standing-order', 'StandingOrderController');
	//hết
	//Sổ quỹ tiền mặt
	Route::resource('cash-book', 'CashBookController');
	Route::post('cash-book/filter', 'CashBookController@filter')->name('cash-book.filter');
	//hết
	//Sổ tiền gửi
	Route::resource('bank-deposit-book', 'BankDepositBookController');
	//hết
});