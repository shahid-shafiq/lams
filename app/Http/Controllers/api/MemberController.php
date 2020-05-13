<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Member;
use App\Receipt;
use App\Person;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function index() {
      return Member::all();
    }

    public function show($mid) {
      $member = Member::findOrFail($mid);
      return $member;
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
