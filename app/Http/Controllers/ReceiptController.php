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
use App\Site;
use App\Period;
use App\Student;
use App\Subincome;

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
    
    $receipts = Receipt::where($condition)->orderByDesc('no')->get();
    return view('receipts.index', [
      'title' => 'Receipts',
      'filter' => $filter,
      'receipts' => $receipts]);
  }

  public function output(Request $request, $output = null) {
    $search = $search = $request->search;

    $condition = ['site_id' => $this->sid, 'period_id' => $this->pid];
    if ($request->session()->has('filter'))  {
      $filter = $request->session()->get('filter', null);
      $condition = array_merge($condition, ['income_id' => $request->session()->get('filter', null)]);
    } else {
      $filter = null;
    }

    if ($search !== "")  {
      //$condition = array_merge($condition, ['title like' => 'منیر احمد']);
      $receipts = Receipt::where('title', 'like', '%'.$search.'%')->where($condition)->orderByDesc('no')->get();
    } else {
      $receipts = Receipt::where($condition)->orderByDesc('no')->get();
    }

    /*
    echo $receipts->count();
    echo "<br>";
    echo $receipts;
    return;
    */
    
    //$receipts = Receipt::where($condition)->orderByDesc('no')->get();

    if ($output === "pdf") {
      $site = Site::find($this->sid);
      $period = Period::find($this->pid);

      return response(
          view('receipts.pdf.income', [
          'period' => $period,
          'data' => $receipts,
          'profile' => Auth()->user()->profile,
          'site' => $site
          ]), 200)
          ->header('Content-Type', 'application/pdf');

    } else {
      return view('receipts.index', [
        'title' => 'Receipts',
        'filter' => $filter,
        'receipts' => $receipts]);
    }
  }

  public function show($id) {
    $receipt = Receipt::findOrFail($id);

    return view('receipts.show', ['title' => 'Receipts', 'receipt' => $receipt, 'debug' => false]);
  }

  public function create() {
    $receipt = Receipt::newReceipt($this->sid, $this->pid);
    //$courses = Student::courses($receipt->department_id);
    $students = Student::students($receipt->department_id, $receipt->account_id);

    return view('receipts.create', [
      'title' => 'Receipt',
      'receipt' => $receipt,
      'mode' => 'create',
      'departments' => Department::all(),
      'accounts' => Account::all(),
      'payments' => Payment::all(),
      'incomes' => Income::all(),
      'courses' => Course::orderBy('id')->get(),
      'subincome' => Subincome::all(),
      'students' => $students,
      'members' => Member::memberListNames(),
      'regnos' => Member::memberListReg()
      ]);
  }

  public function help(Request $request, $hid = null) {
    echo "Helping...";
  }
  
  public function infaaq(Request $request, $hid = null) {
    return view('receipts.infaaq');
  }

  public function hellopost(Request $request) {
    echo $request;
  }

  public function hello(Request $request, $check = null) {
    $mode = 'edit';
    if ($mode == 'edit') {
      $receipt = Receipt::findOrFail(11881);
      $courses = Student::courses($receipt->department_id);
      $students = Student::students($receipt->department_id, $receipt->account_id);
    } else {
      $receipt = Receipt::newReceipt($this->sid, $this->pid);
      $courses = Course::orderBy('id')->get();
      $students = Student::all();
    }
    
    return view('receipts.hello', [
      'title' => 'Receipt',
      'receipt' => $receipt,
      'mode' => $mode,
      'departments' => Department::all(),
      'accounts' => Account::all(),
      'payments' => Payment::all(),
      'incomes' => Income::all(),
      'courses' => $courses,
      'members' => Member::memberListNames(),
      'regnos' => Member::memberListReg(),
      'students' => $students
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
        'title'=>'required'
        //,'amount'=>'required'
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

      if ($inc == '3' || $inc == '2') {
        // date range
        $fd = Carbon::createFromDate($request->get('fdate'));
        $td = Carbon::createFromDate($request->get('tdate'));

        if ($fd > $td) {
          // swap dates
          $tmp = $fd;
          $fd = $td;
          $td = $tmp;
        }

        $receipt->fdate = $fd->firstOfMonth()->toDateString();
        $receipt->tdate = $td->lastOfMonth()->toDateString();

        // reference id (Anjuman member no. or student roll no.)
        $receipt->m_id = $request->get('member');

        if ($inc == '3') {
          // FEE
          $receipt->account_id = $request->get('course');
          if ($receipt->description == '') {
            $receipt->description = Urdutils::FeeDescription($fd, $td);
          }
        } elseif ($inc == '4' || $inc == '5') {
          // SPECIAL or SALE
          $receipt->account_id = $request->get('subincome');
        } else {
          // INFAAQ
          $receipt->description = Urdutils::InfaqDescription($fd, $td);
          $receipt->account_id = 1;
        }      
      }
      
      //return view('receipts.show', ['receipt' => $receipt, 'debug' => true, 'req' => $request]);
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
      $courses = Student::courses($receipt->department_id);
      $students = Student::students($receipt->department_id, $receipt->account_id);
  
      $receipt->course = $receipt->account_id;
      $receipt->student = $receipt->m_id;

      return view('receipts.create', [
        'title' => 'Receipt',
        'mode' => 'edit',
        'receipt' => $receipt,
        'departments' => Department::all(),
        'accounts' => Account::all(),
        'payments' => Payment::all(),
        'incomes' => Income::all(),
        'subincome' => Subincome::subs($receipt->income_id),
        'courses' => $courses,
        'students' => $students,
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

      if ($inc == '5' || $inc == '4' ) {
        // SPECIAL or SALE          
        $receipt->account_id = $request->get('subincome');
      } else if($inc == '3' || $inc == '2') {
        // date range
        $fd = Carbon::createFromDate($request->get('fdate'));
        $td = Carbon::createFromDate($request->get('tdate'));

        if ($fd > $td) {
          // swap dates
          $tmp = $fd;
          $fd = $td;
          $td = $tmp;
        }

        $receipt->fdate = $fd->firstOfMonth()->toDateString();
        $receipt->tdate = $td->lastOfMonth()->toDateString();

        if ($inc == '3') {
          // FEE
          // reference id (Student roll no.)
          $receipt->m_id = $request->get('student');
          $receipt->account_id = $request->get('course');
          if ($receipt->description == '') {
            $receipt->description = Urdutils::FeeDescription($fd, $td);
          }
        } else {
          // INFAAQ
          // reference id (Anjuman member no.)
          $receipt->m_id = $request->get('member');
          $receipt->description = Urdutils::InfaqDescription($fd, $td);
          $receipt->account_id = 1;
        }      
      }

      //return view('receipts.show', ['receipt' => $receipt, 'debug' => true, 'req' => $request]);
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

    public function subincome($inc) {
      return Subincome::where(['income_id' => $inc])->orWhere(['id' => '1'])->orderBy('id')->get();
    }
}
 