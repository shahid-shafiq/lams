<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Balance;

class BalanceController extends Controller
{
  public function index() {
    $balances = Balance::where(['site_id' => $this->sid])
      ->orderBy('period_id', 'desc')
      ->get();
    return view('balances.index', [
      'title' => 'Balances',
      'balances' => $balances]);
  }
}
