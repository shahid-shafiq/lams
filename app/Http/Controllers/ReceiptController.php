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
  /* API
    public function index() {
      return Receipt::paginate();
    }
  */
  private $pid;
  private $sid;

  public function __construct() {
    parent::__construct();

    $this->middleware(function($request, $next) {
      $this->pid = session()->get('period.id');
      $this->sid = session()->get('site.id');
      return $next($request);
    });

  }

  public function index(Request $request) {
    $this->pid = $request->session()->get('period.id');
    $this->sid = $request->session()->get('site.id');

    $receipts = Receipt::where(['site_id' => $this->sid, 'period_id' => $this->pid])->get();
    return view('receipts.index', ['receipts' => $receipts]);
  }

  public function show($id) {
    $receipt = Receipt::findOrFail($id);

    return view('receipts.show', ['receipt' => $receipt]);
  }

  public function create() {
    $receipt = Receipt::newReceipt($this->sid, $this->pid);
    $receipt->rdate = date('Y-m-d');
    /*
    $members = Member::where('status', '<>', 'D')->
      join('people', 'people.id', 'members.person_id')->
      select('members.regno', 'people.fullname')->
      orderBy('people.fullname')->get();
    foreach ($members as $m) {  
      echo $m->fullname . "<br>";
    }
    return;
    */

    return view('receipts.create', [
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

      /*
      $receipt = new Receipt([
          'no' => $request->get('no'),
          'rdate' => $request->get('rdate'),
          'title' => $request->get('title'),
          'description' => $request->get('description'),
          'amount' => $request->get('amount'),

          'payment_id' => $request->get('payment'),
          'income_id' => $request->get('income'),
          'account_id' => $request->get('account'),
          'department_id' => $request->get('department'),
          'period_id' => $this->pid,
          'site_id' => $this->sid,

          'm_id' => $request->get('member'),
          'fdate' => $request->get('fdate'),
          'tdate' => $request->get('tdate'),
      ]);
      */

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
 