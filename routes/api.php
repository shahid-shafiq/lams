<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Receipt;
use App\Sites;
use App\Period;
use App\Bill;
use App\Person;

use App\Http\Controllers\Api\MemberController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('receipts', function() { 
  return App\Member::all(); 
});

Route::get('members/{id}/person', 'api/MemberController@person');
Route::get('members/{id}/infaaq', 'api/MemberController@infaaq');

Route::resource('periods', 'PeriodController', ['only' => ['index', 'store', 'show']]);
Route::resource('receipts', 'ReceiptController', ['only' => ['index', 'store', 'show']]);
Route::resource('members', 'api\MemberController', ['only' => ['index', 'store', 'show']]);
Route::resource('people', 'PersonController', ['only' => ['index', 'store', 'show']]);

//Route::resource('members.infaaq', 'InfaaqController', ['only' => ['index', 'store', 'show']]);
//Route::resource('fee', 'ReceiptController', ['only' => ['index', 'store', 'show']]);
