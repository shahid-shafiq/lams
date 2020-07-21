<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Receipt;
use App\Department;
use App\Income;
use App\Account;
use App\Member;
use App\Course;
use App\Payment;

use Carbon\Carbon;
use App\Custom\Urdutils;

class ReceiptController extends Controller
{
  
  public function __construct() {
    parent::__construct();
    $this->middleware('auth');
  }


  public function index(Request $request) {
    if ($request->filter) {
      $filter = strtolower($request->filter);
      if (in_array($filter, ['infaaq', 'fee'])) {
        session(['filter' => $filter == 'fee' ? 3 : 2]);
      } else {
        $request->session()->forget('filter');
      }
    }
    $filter = $request->session()->get('filter');

    $condition = ['site_id' => $this->sid, 'period_id' => $this->pid];
    if ($request->session()->has('filter'))  {
      $condition = array_merge($condition, ['income_id' => $request->session()->get('filter', null)]);
    }
    
    $receipts = Receipt::where($condition)->get();
    return view('receipts.index', [
      'title' => 'Receipts',
      'filter' => $filter,
      'receipts' => $receipts]);
  }

  public function show($id) {
    $receipt = Receipt::findOrFail($id);

    return view('receipts.show', ['title' => 'Receipts', 'receipt' => $receipt]);
  }

  public function create() {
    $receipt = Receipt::newReceipt($this->sid, $this->pid);
    $receipt->rdate = date('Y-m-d');

    return view('receipts.create', [
      'title' => 'Receipt',
      'receipt' => $receipt,
      'mode' => 'create',
      'departments' => Department::all(),
      'accounts' => Account::all(),
      'payments' => Payment::all(),
      'incomes' => Income::all(),
      'courses' => Course::all(),
      'members' => Member::memberListNames(),
      'regnos' => Member::memberListReg()
      ]);
  }

  public function patchData(Receipt $receipt, Request $request) {
    $receipt = new Receipt([
      'no' => $request->get('no'),
      'rdate' => $request->get('rdate'),
      'title' => $request->get('title'),
      'description' => $request->get('description'),
      'amount' => $request->get('amount'),
      'payment_id' => $request->get('payment'),
      'income_id' => $request->get('income'),
      'department_id' => $request->get('department'),
      'period_id' => $this->pid,
      'site_id' => $this->sid,
      'account_id' => $request->get('account'),
    ]);

    $inc = $request->get('income');

    if ($inc == '3') {
      // FEE
      $receipt->account_id = $request->get('course');
      
    } else if ($inc == '2') {
      // INFAAQ

      $fd = Carbon::createFromDate($request->get('fdate'));
      $td = Carbon::createFromDate($request->get('tdate'));

      if ($fd > $td) {
        // swap dates
        $tmp = $fd;
        $fd = $td;
        $td = $tmp;
      }

      $receipt->m_id = $request->get('member');
      $receipt->fdate = $fd->firstOfMonth()->toDateString();
      $receipt->tdate = $td->lastOfMonth()->toDateString();
      
      $receipt->description = Urdutils::InfaqDescription($fd, $td);
      $receipt->account_id = 1;
    }
  }

  /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'rdate'=>'required',
        'title'=>'required',
        'amount'=>'required'
      ]);

      // field values required for all types of receipts
      $receipt = new Receipt([
        'no' => $request->get('no'),
        'rdate' => $request->get('rdate'),
        'title' => $request->get('title'),
        'description' => $request->get('description'),
        'amount' => $request->get('amount'),
        'payment_id' => $request->get('payment'),
        'income_id' => $request->get('income'),
        'department_id' => $request->get('department'),
        'period_id' => $this->pid,
        'site_id' => $this->sid,
        'account_id' => $request->get('account'),
      ]);

      $inc = $request->get('income');

      if ($inc == '3') {
        // FEE
        $receipt->account_id = $request->get('course');
        
      } else if ($inc == '2') {
        // INFAAQ

        $fd = Carbon::createFromDate($request->get('fdate'));
        $td = Carbon::createFromDate($request->get('tdate'));

        if ($fd > $td) {
          // swap dates
          $tmp = $fd;
          $fd = $td;
          $td = $tmp;
        }

        $receipt->m_id = $request->get('member');
        $receipt->fdate = $fd->firstOfMonth()->toDateString();
        $receipt->tdate = $td->lastOfMonth()->toDateString();
        
        $receipt->description = Urdutils::InfaqDescription($fd, $td);
        $receipt->account_id = 1;
      }
      
      //return view('receipts.show', ['receipt' => $receipt]);
      $receipt->save();
      return redirect('/receipts')->with('success', 'Receipt saved!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $receipt = Receipt::findOrFail($id);
  
      return view('receipts.create', [
        'title' => 'Receipt',
        'mode' => 'edit',
        'receipt' => $receipt,
        'departments' => Department::all(),
        'accounts' => Account::all(),
        'payments' => Payment::all(),
        'incomes' => Income::all(),
        'courses' => Course::all(),
        'members' => Member::memberListNames(),
        'regnos' => Member::memberListReg()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'rdate'=>'required',
        'title'=>'required',
        'amount'=>'required'
      ]);

      // field values required for all types of receipts
      $receipt = Receipt::findOrFail($id);
      $receipt->fill([
        'no' => $request->get('no'),
        'rdate' => $request->get('rdate'),
        'title' => $request->get('title'),
        'description' => $request->get('description'),
        'amount' => $request->get('amount'),
        'payment_id' => $request->get('payment'),
        'income_id' => $request->get('income'),
        'department_id' => $request->get('department'),
        'account_id' => $request->get('account'),
      ]);

      $inc = $request->get('income');

      if ($inc == '3') {
        // FEE
        $receipt->account_id = $request->get('course');
        
      } else if ($inc == '2') {
        // INFAAQ

        $fd = Carbon::createFromDate($request->get('fdate'));
        $td = Carbon::createFromDate($request->get('tdate'));

        if ($fd > $td) {
          // swap dates
          $tmp = $fd;
          $fd = $td;
          $td = $tmp;
        }

        $receipt->m_id = $request->get('member');
        $receipt->fdate = $fd->firstOfMonth()->toDateString();
        $receipt->tdate = $td->lastOfMonth()->toDateString();
        
        $receipt->description = Urdutils::InfaqDescription($fd, $td);
        $receipt->account_id = 1;

        //echo $receipt->title;
      }

      $receipt->save();
      return redirect('/receipts')->with('success', 'Receipt updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $receipt = Receipt::findOrFail($id);
        //echo "Destroy record ".$receipt;
        $receipt->delete();
        return redirect()->route('receipts.index')
              ->with('success','Bill deleted successfully');
    }
}
 