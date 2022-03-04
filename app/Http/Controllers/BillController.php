<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill;
use App\Department;
use App\Expense;
use App\Account;
use App\Member;
use App\Course;
use App\Payment;
use Auth;
use App;

class BillController extends Controller
{
  public function __construct() {
    parent::__construct();
    $this->middleware('auth');
    //App::setLocale("ur_PK");
  }
  
  public function index() { 
    $bills = Bill::where(['site_id' => $this->sid, 'period_id' => $this->pid])->orderByDesc('no')->get();
    return view('bills.index', ['title' => 'Bills', 'bills' => $bills]);
  }

  public function create() {
    $bill = Bill::newBill($this->sid, $this->pid);

    return view('bills.create', [
      'title' => 'Bills',
      'bill' => $bill,
      'mode' => 'create',
      'departments' => Department::all(),
      'accounts' => Account::all(),
      'payments' => Payment::all(),
      'expenses' => Expense::where(['status' => '1'])->get(),
      ]);
  }

  public function store(Request $request) {
    $request->validate([
      'title' => 'required',
      'no' => 'required',
    ]);

    $bill = new Bill([
      'no' => $request->get('no'),
      'bdate' => $request->get('bdate'),
      'title' => $request->get('title'),
      'description' => $request->get('description'),
      'amount' => $request->get('amount'),
      'payment_id' => $request->get('payment'),
      'expense_id' => $request->get('expense'),
      'department_id' => $request->get('department'),
      'period_id' => $this->pid,
      'site_id' => $this->sid,
      'account_id' => $request->get('account'),
    ]);


    $bill->save();
    return redirect()->route('bills.index')
            ->with('success','Bill posted successfully.');
  }

  public function show($id) {
      $bill = Bill::find($id);
      $title = 'Bill';
      return view('bills.show', ['bill' => $bill, 'title' => $title]);
  }

  public function edit($id) {
      $bill = Bill::findOrFail($id);
      $accounts = Account::where(['expense_id' => $bill->expense_id])->orderBy('id')->get();

      return view('bills.create', [
        'title' => 'Bills',
        'mode' => 'edit',
        'bill' => $bill,
        'profile' => Auth::user()->profile,
        'departments' => Department::all(),
        'accounts' => $accounts,
        'payments' => Payment::all(),
        'expenses' => Expense::all(),
        ]);
  }

  public function update(Request $request, $id) {
    $bill = Bill::findOrFail($id);

    $bill->fill([
      'no' => $request->get('no'),
      'bdate' => $request->get('bdate'),
      'title' => $request->get('title'),
      'description' => $request->get('description'),
      'amount' => $request->get('amount'),
      'payment_id' => $request->get('payment'),
      'expense_id' => $request->get('expense'),
      'department_id' => $request->get('department'),
      'period_id' => $this->pid,
      'site_id' => $this->sid,
      'account_id' => $request->get('account'),
    ]);


    $bill->save();
    return redirect()->route('bills.index')
            ->with('success','Bill posted successfully.');
  }

  public function destroy($id) {
    $bill = Bill::findOrFail($id);
    $bill->delete();
    return redirect()->route('bills.index')
              ->with('success','Bill deleted successfully');
  }

  public function subaccounts($exp) {
    return Account::where(['expense_id' => $exp])->orWhere(['id' => '1'])->orderBy('id')->get();
  }
}
