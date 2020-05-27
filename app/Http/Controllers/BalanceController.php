<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Balance;
use App\Period;

class BalanceController extends Controller
{
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
    return view('balances.edit', [
      'title' => 'Balance',
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
