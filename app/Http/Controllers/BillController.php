<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill;

class BillController extends Controller
{
  
  public function index() { 
    $bills = Bill::where(['site_id' => $this->sid, 'period_id' => $this->pid])->get();
    return view('bills.index', ['title' => 'Bills', 'bills' => $bills]);
  }

  public function create() {
    return view('bills.create', ['title' => 'Bills']);
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
      $bill = Bill::find($id);
      $title = 'Bills';
      return view('bills.edit',compact('bill','id', 'title'));
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
