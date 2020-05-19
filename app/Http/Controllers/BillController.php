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

class BillController extends Controller
{
  
  public function index() { 
    $bills = Bill::where(['site_id' => $this->sid, 'period_id' => $this->pid])->get();
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
      'expenses' => Expense::all(),
      ]);
  }

  public function store(Request $request) {
    $request->validate([
      'name' => 'required',
      'email' => 'required',
    ]);

    Bills::create($request->all());

    return redirect()->route('bills.index')
            ->with('success','User created successfully.');
  }

  public function show($id) {
      $bill = Bill::find($id);
      $title = 'Bills';
      return view('bills.show',compact('bill', 'title'));
  }

  public function edit($id) {
      $bill = Bill::findOrFail($id);

      return view('bills.create', [
        'title' => 'Bills',
        'mode' => 'edit',
        'bill' => $bill,
        'departments' => Department::all(),
        'accounts' => Account::all(),
        'payments' => Payment::all(),
        'expenses' => Expense::all(),
        ]);
  }

  public function update($id) {
    $bill = Bill::find($id);
    $bill->name = request('name');
    $bill->email = request('email');
    $bill->save();
    $request->validate([
      'name' => 'required',
      'email' => 'required',
    ]);
    $bill->update($request->all());

    return redirect()->route('bills.index')
            ->with('success','User updated successfully');
  }

  public function destroy($id) {
    Bills::find($id)->delete();
  
    return redirect()->route('bills.index')
              ->with('success','User deleted successfully');
  }
}
