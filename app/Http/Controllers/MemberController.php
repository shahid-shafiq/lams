<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Receipt;
use App\Person;

class MemberController extends Controller
{
    public function index() {
      $members = Member::where('status', '<>', 'D')->
        orWhereNull('status')->get();
      return view('members.index', ['members' => $members]);
    }

    public function show($mid) {
      $member = Member::findOrFail($mid);
      return $member;
    }

    public function destroy($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function person($mid) {
      $member = Member::findOrFail($mid);
      $person = Person::findOrFail($member->person_id);
      return $person;
    }

    public function infaaq($mid) {
      $member = Member::findOrFail($mid);
      $receipts = Receipt::where('m_id', $mid)->get();
      return $receipts;
    }
}
