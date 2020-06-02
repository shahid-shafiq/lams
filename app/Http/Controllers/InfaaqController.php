<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Receipt;
use App\Period;

class InfaaqController extends Controller
{
    public function index($memberId) {
      //return Receipt::where('m_id', $memberId)->get();
      return Description::ofMember($memberId);
    }

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
