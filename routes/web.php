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
	Route::get('cash-receipt-voucher/{id}/note', 'CashReceiptVoucherController@note')->name('cash-receipt-voucher.note');
	//hết
	//phiếu chi
	Route::get('get-list-cash-payment-voucher', 'CashPaymentVoucherController@getList')->name('get-list-cash-payment-voucher');
	Route::resource('cash-payment-voucher', 'CashPaymentVoucherController');
	Route::get('cash-payment-voucher/{id}/note', 'CashPaymentVoucherController@note')->name('cash-payment-voucher.note');
	//hết
	//Giay báo có
	Route::get('get-list-credit-note', 'CreditNoteController@getList')->name('get-list-credit-note');
	Route::resource('credit-note', 'CreditNoteController');
	Route::get('credit-note/{id}/note', 'CreditNoteController@note')->name('credit-note.note');
	//hết
	//Giay báo có
	Route::get('get-list-standing-order', 'StandingOrderController@getList')->name('get-list-standing-order');
	Route::resource('standing-order', 'StandingOrderController');
	Route::get('standing-order/{id}/note', 'StandingOrderController@note')->name('standing-order.note');
	//hết
	//Sổ quỹ tiền mặt
	Route::resource('cash-book', 'CashBookController');
	Route::post('cash-book/filter', 'CashBookController@filter')->name('cash-book.filter');
	Route::post('cash-book/print', 'CashBookController@print')->name('cash-book.print');
	Route::get('cash-book/print/show', 'CashBookController@printShow')->name('cash-book.print-show');
	//hết
	//Sổ tiền gửi
	Route::resource('bank-deposit-book', 'BankDepositBookController');
	Route::post('bank-deposit-book/filter', 'BankDepositBookController@filter')->name('bank-deposit-book.filter');
	Route::post('bank-deposit-book/print', 'BankDepositBookController@print')->name('bank-deposit-book.print');
	Route::get('bank-deposit-book/print/show', 'BankDepositBookController@printShow')->name('bank-deposit-book.print-show');
	//hết
	//quyền hạn
	Route::get('list-permission', ['as' => 'users.list-permission', 'uses' => 'PermissionController@getListPermission']);
	Route::resource('permissions', 'PermissionController');
	//hết
	//vai trò
	Route::get('roles/{name}/permissions', 'RoleController@getPermissions')->name('user.role-permissions');

	Route::get('roles/list-permissions/{name}', 'RoleController@getListPermission')->name('user.role-list-permissions');

	Route::post('roles/permissions', 'RoleController@postPermissions')->name('user.update-role-permissions');

	Route::get('list-role', ['as' => 'users.list-role', 'uses' => 'RoleController@getListRole']);

	Route::resource('roles', 'RoleController');
	//hết
	//người dùng
	Route::get('users/get_all_user_select_option', 'User\UserController@getAllUserSelectOption')->name('user.getAllUserSelectOption');

	Route::get('users/{id}/roles', 'User\UserController@getRoles')->name('user.roles');

	Route::post('users/roles', 'User\UserController@postRoles')->name('user.update-roles');

	Route::get('list-user', ['as' => 'users.list-user', 'uses' => 'User\UserController@getListUser']);

	Route::resource('users', 'User\UserController');

	Route::post('get-info-user', 'User\UserController@getInfoUser')
	->name('get-info-user');

	Route::post('update-info-user', 'User\UserController@updateInfoUser')
	->name('update-info-user');
	//hết
	//nhân viên
	Route::resource('employees', 'EmployeeController');
	Route::get('list-employee', ['as' => 'employees.list-employee', 'uses' => 'EmployeeController@getListEmployee']);
	//hết
	//nhân viên
	Route::resource('customers', 'EmployeeController');
	//hết
	//nhà cung cấp
	Route::resource('suppliers', 'EmployeeController');
	//hết
	//tiền tệ
	Route::resource('moneys', 'MoneyController');
	Route::get('list-money', ['as' => 'moneys.list-money', 'uses' => 'MoneyController@getListMoney']);
	//hết
	//ngân hàng
	Route::resource('banks', 'BankController');
	Route::get('list-bank', ['as' => 'banks.list-bank', 'uses' => 'BankController@getListBank']);
	//hết
	//tài khoản ngân hàng
	Route::resource('bank-accounts', 'BankAccountController');
	Route::get('list-bank-account', ['as' => 'bank-accounts.list-bank-account', 'uses' => 'BankAccountController@getListBankAccount']);
	//hết
});