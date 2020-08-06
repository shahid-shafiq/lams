<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Acctrans;
use App\Translist;

class TransController extends Controller
{
    public function __construct() {
    parent::__construct();
    $this->middleware('auth');
    }

    public function index() {
        $BANK = 2;

        $trans = Acctrans::where([
            'site_id' => $this->sid, 
            'period_id' => $this->pid])
            ->where(function($query) use ($BANK) {
                $query->where('from_account', $BANK)
                ->orWhere('to_account', $BANK);
            })            
            ->get();

        return view('bank.index', [
        'title' => 'Transactions',
        'trans' => $trans,
        ]);
    }

    public function create() {
        $trans = new Acctrans();
        return view('bank.create', [
          'title' => 'Transactions',
          'mode' => 'create',
          'translist' => Translist::all(),
          'trans' => $trans
          ]);
      }
    
      public function store(Request $request) {
        $request->validate([
          'from_account' => 'required',
          'to_account' => 'required',
        ]);
    
        $trans = new Acctrans([
          'trans_date' => $request->get('trans_date'),
          'description' => $request->get('description'),
          'amount' => $request->get('amount'),

          'from_account' => $request->get('from_account'),
          'to_account' => $request->get('to_account'),
          'ref' => $request->get('ref'),

          'period_id' => $this->pid,
          'site_id' => $this->sid
        ]);
    
    
        $trans->save();
        return redirect()->route('bank.index')
                ->with('success','Transaction posted successfully.');
      }
}
