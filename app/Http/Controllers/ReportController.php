<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Period;
use App\Receipt;
use App\Bill;
use App\Balance;
use App\Infaaq;
use App\Site;
use Auth;
use DB;

class ReportController extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    private function selectPeriod(Request $request) {
        $pid = $request->get('pid');
        $session = $request->getSession();
        
        $this->plist = Period::orderBy('start', 'desc')->get();
        
        if ($pid === null) {            
            $pid = $session->get("report.period");
            if ($pid === null && Auth::check()) {
                $pid = Auth::user()->period_id;
            }
        }
             
        $this->period = Period::where(['id' => $pid])->first();
        if ($this->period == null) {
            $this->period = new Period([
                'title' => '',
                'id' =>  Auth::check() ? Auth::user()->period_id : 0
            ]);
        }
        
        // store selected period as session variable
        $session->put("report.period", $pid);
        return $pid;
    }

    public function index(Request $request, $output = null) {
        $pid = $this->selectPeriod($request);

        $ixr = (object)[];
        $ixr->pbalance = 0.0;
        $ixr->pid = $pid;

        $inc = Receipt::periodIncome($this->sid, $pid);
        $exp = Bill::periodExpense($this->sid, $pid);
        $bal = Balance::where(['period_id' => $pid, 'site_id' => $this->sid])->first();
        
        if ($bal != null) {
            $ixr->opening = $bal->opening;
        } else {
            $ixr->opening = 0;
        }
        
        $ixr->isum = $inc->isum;        
        $ixr->esum = $exp->esum;
        
        $ixr->tincome = $ixr->pbalance+$ixr->isum + $ixr->opening;
        $ixr->balance = $ixr->tincome - $ixr->esum;
 
        if ($output === "pdf") {
            $site = Site::find($this->sid);

            return response(
                view('reports.pdf.profit', [
                'period' => $this->period,
                'ixr' => $ixr,
                'pid' => $pid,
                'site' => $site,
                'profile' => Auth::user()->profile,
                ]), 200)
                ->header('Content-Type', 'application/pdf');
        } else {
            return view('reports.index', [
                'title' => 'Reports',
                'periods' => Period::orderBy('id', 'desc')->get(),
                'period' => $this->period,
                'ixr' => $ixr,
                'pid' => $pid,
            ]);
        }
    }

    public function income(Request $request, $output = null)
    {      
        $pid = $this->selectPeriod($request);
        $receipts = Receipt::where(['period_id' => $pid, 'site_id' => $this->sid])
            ->orderby('no', 'asc')->get();
        
        if ($output === "pdf") {
            $site = Site::find($this->sid);

            return response(
                view('reports.pdf.income', [
                'period' => $this->period,
                'data' => $receipts->toArray(),
                'profile' => Auth::user()->profile,
                'site' => $site
                ]), 200)
                ->header('Content-Type', 'application/pdf');

        } else {
            return view('reports.income', [
                'title' => 'Reports',
                'periods' => Period::orderBy('id', 'desc')->get(),
                'period' => $this->period,
                'receipts' => $receipts,
            ]);
        }
    }

    public function expense(Request $request, $output = null)
    {      
        $pid = $this->selectPeriod($request);
        $bills = Bill::where(['period_id' => $pid, 'site_id' => $this->sid])
            ->orderby('no', 'asc')->get();
        
        if ($output === 'pdf') {
            $site = Site::find($this->sid);

            return response(
                view('reports.pdf.expense', [
                    'period' => $this->period,
                    'data' => $bills->toArray(),
                    'profile' => Auth::user()->profile,
                    'site' => $site
                ]), 200)
                ->header('Content-Type', 'application/pdf');
        } else {
            return view('reports.expense', [
                'title' => 'Reports',
                'periods' => Period::orderBy('id', 'desc')->get(),
                'period' => $this->period,
                'bills' => $bills,
            ]);
        }
    }

    public function vouchers(Request $request, $output = null)
    {      
        $pid = $this->selectPeriod($request);
        
        if ($output === 'pdf') {
            $bills = Bill::where(['period_id' => $pid, 'site_id' => $this->sid])
            ->orderby('no', 'asc')->get();

            $site = Site::find($this->sid);

            return response(
                view('reports.pdf.vouchers', [
                    'period' => $this->period,
                    'data' => $bills->toArray(),
                    'profile' => Auth::user()->profile,
                    'site' => $site
                ]), 200)
                ->header('Content-Type', 'application/pdf');
        } else {
            $bills = Bill::where(['period_id' => $pid, 'site_id' => $this->sid])
            ->orderby('no', 'asc')
            ->paginate(11);

            return view('reports.vouchers', [
                'title' => 'Reports',
                'periods' => Period::orderBy('id', 'desc')->get(),
                'period' => $this->period,
                'bills' => $bills,
            ]);
        }
    }

    public function infaaq(Request $request, $output = null)
    {      
        $pid = $this->selectPeriod($request);

        $year = $request->get('year');
        if ($year == null) {
            $year = date("Y");
        }

        $years = Receipt::select(DB::Raw('distinct year(tdate) as year'))
            ->whereNotNull('tdate')
            ->where('tdate', '>', '2010')
            ->orderBy('year', 'desc')
            ->get();

        $data = Infaaq::infaaqData($year);

        if ($output === 'csv') {
            $fn = 'infaaq-'.$year.'.csv';
            return $this->export($data, $fn)  ;          
        } else {
            return view('reports.infaaq', [
                'title' => 'Reports',
                'periods' => Period::orderBy('id', 'desc')->get(),
                'period' => $this->period,
                'year' => $year,
                'years' => $years,
                'data' => $data,
            ]);
        }
    }

    protected function export($data, $fn)
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=".$fn,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array("Name","RegNo","Mobile","Pledge","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

        $callback = function() use ($columns, $data)
        {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, $columns);
            foreach($data as $row) {
                fputcsv($file, $row); 
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
