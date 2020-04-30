<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Receipt;

class InfaaqController extends Controller
{
    public function index($memberId) {
      //return Receipt::where('m_id', $memberId)->get();
      return Description::ofMember($memberId);
    }
}
