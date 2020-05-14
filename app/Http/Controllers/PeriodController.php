<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Period;

class PeriodController extends Controller
{
    public function index() {
      return view('periods.index', [
        'title' => 'Periods',
        'periods' => Period::orderBy('id', 'desc')->get()]);
    }
}
