<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Period;

class PeriodController extends Controller
{
  public function __construct() {
    parent::__construct();
    $this->middleware('auth');
  }

    public function index() {
      return view('periods.index', [
        'title' => 'Periods',
        'periods' => Period::orderBy('id', 'desc')->get()]);
    }

    public function show($id) {
      $period = Period::findOrFail($id);
      return view('periods.show', [
        'title' => 'Period',
        'period' => $period]);
    }

    public function create() {
      return view('periods.create', ['title'=>'Period', 'mode'=>'create', 'period'=>new Period()]);
    }

    public function store(Request $request) {
      $request->validate([
        'title'=>'required',
      ]);
  
      // field values required for all types of receipts
      $period = new Period([
        'title' => $request->get('title'),
        'start' => $request->get('start'),
        'end' => $request->get('end'),
      ]);
  
      //return view('members.show', ['member' => $member]);
      $period->save();
      return redirect()->route('periods.index')
                ->with('success','Period created successfully');
    }

    public function destroy($id)
    {
      $period = Period::findOrFail($id);
      $period->delete();
      return redirect()->route('periods.index')
            ->with('success','Period deleted successfully');
    }

    public function update(Request $request, $id) {
      $request->validate([
        'title'=>'required',
      ]);
  
      // field values required for all types of receipts
      $period = Period::findOrFail($id);
      $period->fill([
        'title' => $request->get('title'),
        'start' => $request->get('start'),
        'end' => $request->get('end'),
      ]);
  
      //return view('members.show', ['member' => $member]);
      $period->save();
      return redirect()->route('periods.index')
                ->with('success','Period created successfully');
    }

    public function edit($id) {
      $period = Period::findOrFail($id);
      return view('periods.create', ['title'=>'Period', 'mode'=>'edit', 'period'=>$period]);
    }

}
