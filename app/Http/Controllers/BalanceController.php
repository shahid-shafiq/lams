<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Balance;
use App\Period;
use App\Receipt;
use App\Bill;

class BalanceController extends Controller
{
  public function __construct() {
    parent::__construct();
    $this->middleware('auth');
  }
  
  public function index() {
    $current = Balance::where(['site_id' => $this->sid, 'period_id' => $this->pid])->first();

    //if ($current == null || $current->count() == 0) echo "EMPTY EMPTY EMPTY";
    //else echo "NOT EMPTY >> " . $current;
 
    $balances = Balance::where(['site_id' => $this->sid])
      ->orderBy('period_id', 'desc')
      ->get();
    return view('balances.index', [
      'title' => 'Balances',
      'balances' => $balances,
      'current' => $current]);
  }

  public function edit($id) {
    $bal = Balance::findOrFail($id);
    $sums = (object)[];
    $sums->inc = Receipt::periodIncome($this->sid, $bal->period_id);
    $sums->exp = Bill::periodExpense($this->sid, $bal->period_id);
    return view('balances.edit', [
      'title' => 'Balance',
      'sums' => $sums,
      'balance' => $bal
    ]);
  }

  public function update(Request $request, $id) {
    $bal = Balance::findOrFail($id);
    $bal->fill($request->all());
    $bal->save();
    return redirect()->route('balances.index');
  }

  public function create() {
    /*
    select * from periods p left join 
    (select * from balances where (site_id = 4)) as bp 
    on bp.period_id = p.id
    order by p.id desc
    */
    $bal = Balance::where(['site_id' => $this->sid])->select('id as balid', 'opening', 'income', 'expense', 'balance', 'period_id');

    $balances = Period::leftJoinSub($bal, 'bp', function ($join) {
        $join->on('bp.period_id', '=', 'periods.id');
    })->orderBy('periods.id', 'desc')->get();

    return view('balances.missing', [
      'title' => 'Balances',
      'balances' => $balances,
      ]);
  }

  public function setup($pid) {
    //echo 'Seup for ' . $pid;
    $bal = new Balance();
    $bal->period_id = $pid;
    $bal->site_id = $this->sid;
    $bal->save();
    return redirect()->route('balances.create');
  }
}
