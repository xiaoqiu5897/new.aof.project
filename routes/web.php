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

	Route::get('profiles', ['as' => 'users.profiles', 'uses' => 'User\ProfileController@getProfiles']);
	Route::post('updateavatar', ['as' => 'users.updateavatar', 'uses' => 'User\ProfileController@updateavatar']);

	Route::put('profiles', ['as' => 'users.update-profiles', 'uses' => 'User\ProfileController@putUpdateProfiles']);
	
	Route::put('update-password', ['as' => 'users.update-password', 'uses' => 'User\ProfileController@putUpdatePassword']);

	Route::get('list-user', ['as' => 'users.list-user', 'uses' => 'User\UserController@getListUser']); 
  
	Route::get('users/{id}/coursewares', 'User\UserController@getCourseware');
	Route::get('users/{id}/listCourseware', 'User\UserController@listCourseware');
	Route::get('users/{id}/listexercise', 'User\UserController@listexercise');

	Route::get('users/list-theory', 'User\UserController@getListTheory')->name('user.list-theory');

	Route::post('users/toggle-theories', 'User\UserController@postToggleTheories')->name('user.toggle-theories');

	Route::post('users/toggle-exercises', 'User\UserController@postToggleExercises')->name('user.toggle-exercises');

	Route::resource('users', 'User\UserController');

	Route::post('get-info-user', 'User\UserController@getInfoUser')
	->name('get-info-user');

	Route::post('update-info-user', 'User\UserController@updateInfoUser')
	->name('update-info-user');

	Route::post('unlock-user','User\UserController@unlockUser')->name('unlock_user');
	//hết
});