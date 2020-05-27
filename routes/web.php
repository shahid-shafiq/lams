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
Route::get('reports', 'ReportController@index')->name('reports');
Route::POST('balances/setup/{period}', 'BalanceController@setup')->name('balances.setup');