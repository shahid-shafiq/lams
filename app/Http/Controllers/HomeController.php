<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Receipt;
use App\Bill;
use App\Site;
use App\Period;
use App\Department;
use App\Income;
use App\Expense;
use Auth;
use DB;

class HomeController extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
        //$locale = $user->profile->locale; //"ur_PK";
        //App::setLocale($locale);
    }
    
    //
    public function index() {
        $period = Period::find($this->pid);
        $site = Site::find($this->sid);

        //echo (Auth::user()->profile->locale);
        //echo (Auth::user()->profile);

        $incomes = Receipt::select(
            'income_id', 'department_id', DB::Raw('sum(amount) as income_sum')
        )
            ->where(['site_id' => $this->sid, 'period_id' => $this->pid])
            ->groupBy('department_id')
            ->groupBy('income_id')
            ->get();

        $incsum = Receipt::where(['site_id' => $this->sid, 'period_id' => $this->pid])
            ->sum('amount');

        $expenses = Bill::select(
            'expense_id', 'department_id', DB::Raw('sum(amount) as expense_sum')
        )
            ->where(['site_id' => $this->sid, 'period_id' => $this->pid])
            ->groupBy('department_id')
            ->groupBy('expense_id')
            ->get();

        $expsum = Bill::where(['site_id' => $this->sid, 'period_id' => $this->pid])
            ->sum('amount');

        $incomes->isum = $incsum;
        $expenses->esum = $expsum;

        $dptlist = Department::get();
        $explist = Expense::get();
        $inclist = Income::get();

        return view('home', [
            'title' => 'Home',
            'incomes' => $incomes, 
            'expenses' => $expenses,
            'dptlist' => $dptlist,
            'explist' => $explist, 
            'inclist' => $inclist
        ]);
    }

    public function feedetail() 
    {
        $FEE = 3;
        $pid = 93;
        $sid = 4;
        $fee = Receipt::feeDetail($this->sid, $this->pid);
        //$fee = Receipt::feeDetail($sid, $pid);
        /*
        $fee = Receipt::
              select([
                  'department_id', 'account_id',
                  DB::Raw('sum(amount) as sum')])
              ->where(['income_id' => $FEE, 'period_id' => $pid, 'site_id' => $sid])
              ->groupBy('department_id')
              ->groupBy('account_id')
              ->get();
        */

        return view('fee', [
            'title' => 'Fee',
            'fee' => $fee, 
        ]);
    }
}
