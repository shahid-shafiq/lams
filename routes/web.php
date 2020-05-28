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

Route::get('/', function () {
    return view('home');
})->name('home');

//Route::resource('bills', 'BillsController');
//Route::get('bills', 'BillsController@index');

Route::get('login', 'UserController@login')->name('login');
Route::get('logout', 'UserController@logout')->name('logout');
Route::post('login', 'UserController@authenticate')->name('authenticate');

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
