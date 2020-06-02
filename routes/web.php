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
    return view('hello');
});

// ajax testing
Route::get('/mlist','InfaaqController@mlist');
Route::get('/getmsg','InfaaqController@hi');
Route::post('/getmsg','InfaaqController@hello')->name('ajaxRequest.post');

 // AJAX


 // routes
Route::get('/', 'HomeController@index')->name('home');
Route::get('/fee', 'HomeController@feedetail')->name('home.feedetail');
Route::get('/profile', 'UserController@profile')->name('profile');
Route::post('/profile', 'UserController@updateprofile')->name('update.profile');

//security
Route::get('login', 'AuthController@login')->name('login');
Route::get('logout', 'AuthController@logout')->name('logout');
Route::post('login', 'AuthController@authenticate')->name('authenticate');

Route::resource('receipts', 'ReceiptController');
Route::resource('bills', 'BillController');
Route::resource('members', 'MemberController');

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

//pdf reports
//Route::get('reports/pdf', 'PDFController@profitpdf')->name('reports.pdf');
//Route::get('reports/income/pdf', 'PDFController@incomepdf')->name('income.pdf');
//Route::get('reports/expense/pdf', 'PDFController@incomepdf')->name('expense.pdf');
//Route::get('reports/vouchers/pdf', 'PDFController@incomepdf')->name('vouchers.pdf');
