<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Receipt;
use App\Infaaq;
use App\Period;
use Carbon\Carbon;

class InfaaqController extends Controller
{
    public function index($memberId) {
      //return Receipt::where('m_id', $memberId)->get();
      return Description::ofMember($memberId);
    }

    public function infaaq($memberId) {
      return Infaaq::infaaqByMember($memberId);
    }
    /*
    public function infaaq($memberId) {
      $receipts = Receipt::where('m_id', $memberId)->
        orderBy('fdate')->get();

      $data = array();
      $cy = 0;
      $ym = [0,0,0,0,0,0,0,0,0,0,0,0];

      foreach ($receipts as $receipt) {
        $from = Carbon::createFromDate($receipt->fdate);
        $to = Carbon::createFromDate($receipt->tdate);      

        $dt = $from;
        if ($cy === 0) {
          $cy = $dt->year;
        }

        // iterate over date range (fdate-tdate)
        while ($dt <= $to) {
          $y = $dt->year;
          if ($y !== $cy) {
            $rec['year'] = $cy;
            $rec['month'] = $ym;
            $data[] = $rec;
            $ym = [0,0,0,0,0,0,0,0,0,0,0,0];
            $cy = $y;
          }
          $m = $dt->month;
          $ym[$m-1] = $receipt->no;
            
          $dt->addMonth(1);
        }
      }

      $rec['year'] = $cy;
      $rec['month'] = $ym;
      $data['member'] = $memberId;
      //$data['fd'] = $from;
      //$data['td'] = $to;
      $data['infaaq'] = $rec;
      return $data;
    }
    */

    public function hi() {
      return view('test');
    }

    public function mlist() {
      return Period::get();
    }

    public function hello(Request $request) {
      \Log::info($request->all());
      
      $res = json_encode(Period::get());
      return response()->json(['success'=>$res]);
    }
}
