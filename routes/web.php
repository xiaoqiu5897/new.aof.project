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
	Route::get('dashboard', 'HomeController@index');
	//phiếu thu
	Route::resource('cash-receipt-voucher', 'CashReceiptVoucherController');
	//hết
	//phiếu chi
	Route::resource('cash-payment-voucher', 'CashPaymentVoucherController');
	//hết
});