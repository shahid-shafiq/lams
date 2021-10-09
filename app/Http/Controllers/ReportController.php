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
    const DB_INFAQ = 2;
    const DB_FEE = 3;
    const DB_SPECIAL = 4;
    const DB_SALE = 5;
    const DB_GENRAL = 1;
    const DB_ADJUSTMENT = 6;

    const F_INFAQ = 1;
    const F_FEE = 2;
    const F_SPECIAL = 4;
    const F_SALE = 8;
    const F_OTHER = 16;


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
                'profile' => Auth::user()->profile,
                'receipts' => $receipts,
            ]);
        }
    }

    private function get_filter_receipts($request, $filter) {
        $def = true;
        $query = Receipt::where(['site_id' => $this->sid]);

        

        $flags = $filter->infaaq == true;           // 1 (DB = 2)
        $flags |= ($filter->fee == true) << 1;      // 2 (DB = 3)
        $flags |= ($filter->special == true) << 2;  // 4 (DB = 4)
        $flags |= ($filter->sale == true) << 3;     // 8 (DB = 5)
        $flags |= ($filter->other == true) << 4;    // 16
        
        if ($filter->brange) {
            $def = false;
            $query = $query->where([
                ['no', '>=', $filter->frange],
                ['no', '<=', $filter->lrange] 
            ]);
        } 
            
        if ($filter->bperiod) {
            $def = false;
            $query = $query->where([
                ['period_id', '>=', $filter->fperiod],
                ['period_id', '<=', $filter->tperiod] 
            ]);  
        }

        if ($flags < 31) {
            $income = [];
            if ($flags & $this::F_INFAQ) {
                $income[] = $this::DB_INFAQ;
            }

            if ($flags & $this::F_FEE) {
                $income[] = $this::DB_FEE;
            }

            if ($flags & $this::F_SPECIAL) {
                $income[] = $this::DB_SPECIAL;
            }

            if ($flags & $this::F_SALE) {
                $income[] = $this::DB_SALE;
            }

            if ($flags & $this::F_OTHER) {
                $income[] = $this::DB_GENRAL;
                $income[] = $this::DB_ADJUSTMENT;
            }

            $query = $query->whereIn('income_id', $income);
        }
        
        if ($filter->bdate) {
            $def = false;
            $query = $query->where([
                ['rdate', '>=', $filter->fdate],
                ['rdate', '<=', $filter->tdate] 
            ]);
        } 
            
        if ($def) {
            $pid = $this->selectPeriod($request);
            $query = $query->where(['period_id' => $pid, 'site_id' => $this->sid]);
        }

        $receipts = $query->limit(2000)->orderby('no', 'asc')->get();
        return [$receipts, $def];
    }

    public function income_advanced(Request $request, $output = null)
    {     
        if ($request->isMethod('post')) {
            $filter = new \stdClass();
            $filter->brange = $request->get('brange');
            $filter->frange = $request->get('frange');
            $filter->lrange = $request->get('lrange');

            $filter->bdate = $request->get('bdate');
            $filter->fdate = $request->get('fdate');
            $filter->tdate = $request->get('tdate');

            $filter->bperiod = $request->get('bperiod');
            $filter->fperiod = $request->get('fperiod');
            $filter->tperiod = $request->get('tperiod');

            $filter->fee = $request->get('fee');
            $filter->infaaq = $request->get('infaaq');
            $filter->special = $request->get('special');
            $filter->sale = $request->get('sale');
            $filter->other = $request->get('other');

            $res = $this->get_filter_receipts($request, $filter);
            $receipts = $res[0]; 
            $request->session()->put('advfilter', $filter);
        } else if ($request->session()->has('advfilter')) {
            $filter = $request->session()->get('advfilter');
            $res = $this->get_filter_receipts($request, $filter);
            $receipts = $res[0]; 
        } else {
            $pid = $this->selectPeriod($request);
            $receipts = Receipt::where(['period_id' => $pid, 'site_id' => $this->sid])
                ->orderby('no', 'asc')->get();

            $res = [$receipts, true];

            $filter = new \stdClass();
            $filter->brange = false;
            $filter->bdate = false;
            $filter->bperiod = false;
            
            $filter->infaaq  = true;
            $filter->fee = true;
            $filter->special = true;
            $filter->sale = true;
            $filter->other = true;
        }

        // defaults
        if ($res[1]) {
            if ($receipts->count() > 0) {
                $filter->frange = $receipts[0]->no;
                $filter->lrange = $receipts[$receipts->count()-1]->no;

                $filter->fdate = $receipts[0]->rdate;
                $filter->tdate = $receipts[$receipts->count()-1]->rdate;

                $filter->fperiod = $receipts[0]->period_id;
                $filter->tperiod = $receipts[$receipts->count()-1]->period_id;
            }

            //$filter->infaaq  = true;
            //$filter->fee = true;
            //$filter->special = true;
            //$filter->sale = true;
            //$filter->other = true;
        }

        if ($output === "pdf") {
            $site = Site::find($this->sid);

            return response(
                view('reports.pdf.income', [
                'period' => null,
                'data' => $receipts->toArray(),
                'profile' => Auth::user()->profile,
                'site' => $site
                ]), 200)
                ->header('Content-Type', 'application/pdf');

        } else {
            return view('reports.advanced.income', [
                'title' => 'Advanced Reports',
                'periods' => Period::orderBy('id', 'desc')->get(),
                //'period' => $this->period,
                'profile' => Auth::user()->profile,
                'filter' => $filter,
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
        $profile = Auth::user()->profile;
        
        if ($output === 'pdf') {
            $bills = Bill::where(['period_id' => $pid, 'site_id' => $this->sid])
            ->orderby('no', 'asc')->get();

            $site = Site::find($this->sid);

            return response(
                view('reports.pdf.vouchers', [
                    'period' => $this->period,
                    'data' => $bills->toArray(),
                    'profile' => $profile,
                    'site' => $site
                ]), 200)
                ->header('Content-Type', 'application/pdf');
        } else {
            $bills = Bill::where(['period_id' => $pid, 'site_id' => $this->sid])
            ->orderby('no', 'asc')
            ->paginate($profile->vouchers_pagesize);

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
        $session = $request->getSession();
        $pid = $this->selectPeriod($request);

        $year = $request->get('year');
        if ($year == null) {
            $year = $session->get("report.year", date("Y"));
        } else {
            $session->put("report.year", $year);
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
