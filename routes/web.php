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
    return view('accounts');
});

//Route::resource('bills', 'BillsController');
//Route::get('bills', 'BillsController@index');

Route::resource('receipts', 'ReceiptController');
Route::get('site', 'SiteController@index');