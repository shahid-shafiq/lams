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

class PDFController extends Controller
{
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

    public function profitpdf(Request $request, $pdf = null) {
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

        

        
    }
}
