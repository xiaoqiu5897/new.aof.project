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
	//Sổ cái
	Route::resource('main-ledger', 'MainLedgerController');
	Route::post('main-ledger/filter', 'MainLedgerController@filter')->name('main-ledger.filter');
	Route::post('main-ledger/print', 'MainLedgerController@print')->name('main-ledger.print');
	Route::get('main-ledger/print/show', 'MainLedgerController@printShow')->name('main-ledger.print-show');
	//hết
	//Sổ nhật ký thu tiền
	Route::resource('diary-receipt', 'MainLedgerController');
	Route::post('diary-receipt/filter', 'MainLedgerController@filter')->name('diary-receipt.filter');
	Route::post('diary-receipt/print', 'MainLedgerController@print')->name('diary-receipt.print');
	Route::get('diary-receipt/print/show', 'MainLedgerController@printShow')->name('diary-receipt.print-show');
	//hết
	//Sổ cái Sổ nhật ký chi tiền
	Route::resource('diary-payment', 'MainLedgerController');
	Route::post('diary-payment/filter', 'MainLedgerController@filter')->name('diary-payment.filter');
	Route::post('diary-payment/print', 'MainLedgerController@print')->name('diary-payment.print');
	Route::get('diary-payment/print/show', 'MainLedgerController@printShow')->name('diary-payment.print-show');
	//hết
	//Sổ báo cáo tồn quỹ
	Route::resource('cash-inventory', 'MainLedgerController');
	Route::post('cash-inventory/filter', 'MainLedgerController@filter')->name('cash-inventory.filter');
	Route::post('cash-inventory/print', 'MainLedgerController@print')->name('cash-inventory.print');
	Route::get('cash-inventory/print/show', 'MainLedgerController@printShow')->name('cash-inventory.print-show');
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
});