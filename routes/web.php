<?php

use Illuminate\Support\Facades\Route;

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

/*
Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');
*/

Route::get('/hello', function() {
    App::setLocale('ur');
    return view('hello');
});

// ajax testing
Route::get('/test',function() {
    return view('welcome');
});
Route::get('/vue',function() {
    return view('vue');
});


// AJAX
Route::get('api/mlist','InfaaqController@mlist');
Route::get('api/getmsg','InfaaqController@hi');
Route::post('api/getmsg','InfaaqController@hello')->name('ajaxRequest.post');
Route::get('api/infaaq/{id}','InfaaqController@infaaq');

Route::get('api/courses/{cmpid}','FeeController@courses');
Route::get('api/students/{cmpid}/{crsid}','FeeController@students');
Route::get('api/subaccounts/{expid}','BillController@subaccounts');


 // routes
Route::get('/', 'HomeController@index')->name('home');
Route::get('/fee', 'HomeController@feedetail')->name('home.feedetail');
Route::get('/profile', 'UserController@profile')->name('profile');
Route::post('/profile', 'UserController@updateprofile')->name('update.profile');

//security
Route::get('login', 'AuthController@login')->name('login');
Route::get('logout', 'AuthController@logout')->name('logout');
Route::post('login', 'AuthController@authenticate')->name('authenticate');

Route::get('receipts/output/{output?}', 'ReceiptController@output')->name('receipts.output');
Route::get('receipts/hello', 'ReceiptController@hello')->name('receipts.hello');
Route::post('receipts/hello', 'ReceiptController@hellopost')->name('receipts.hellopost');
Route::get('receipts/infaaq', 'ReceiptController@infaaq')->name('receipts.infaaq');

//Route::get('receipts/help/{hid?}','ReceiptController@help');
Route::resource('receipts', 'ReceiptController');

Route::resource('bills', 'BillController');
Route::resource('members', 'MemberController');
Route::resource('membersold', 'MemberOldController');
Route::post('members/{member}/remove', 'MemberController@remove')->name('members.remove');

Route::resource('persons', 'PersonController');
Route::resource('users', 'UserController');
Route::resource('periods', 'PeriodController');
Route::resource('balances', 'BalanceController');

Route::get('site', 'SiteController@index');
Route::get('admin', ['middleware'=>'auth', 'uses'=>'AdminController@index'])->name('admin');
Route::POST('balances/setup/{period}', 'BalanceController@setup')->name('balances.setup');

//reports
Route::get('reports/income/{output?}', 'ReportController@income')->name('reports.income');
Route::get('reports/expense/{output?}', 'ReportController@expense')->name('reports.expense');
Route::get('reports/vouchers/{output?}', 'ReportController@vouchers')->name('reports.vouchers');
Route::get('reports/infaaq/{output?}', 'ReportController@infaaq')->name('reports.infaaq');
Route::get('reports/dues/{output?}', 'ReportController@dues')->name('reports.dues');
Route::get('reports/{output?}', 'ReportController@index')->name('reports');
Route::match(['get', 'post'], 'reports/advanced/income/{output?}', 'ReportController@income_advanced')->name('reports.advanced.income');
Route::match(['get', 'post'], 'reports/advanced/expense/{output?}', 'ReportController@expense_advanced')->name('reports.advanced.expense');

//bank transactions
Route::resource('bank', 'TransController');

//pdf reports
//Route::get('reports/pdf', 'PDFController@profitpdf')->name('reports.pdf');
//Route::get('reports/income/pdf', 'PDFController@incomepdf')->name('income.pdf');
//Route::get('reports/expense/pdf', 'PDFController@incomepdf')->name('expense.pdf');
//Route::get('reports/vouchers/pdf', 'PDFController@incomepdf')->name('vouchers.pdf');
