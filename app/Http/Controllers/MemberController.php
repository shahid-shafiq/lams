<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Receipt;
use App\Person;

class MemberController extends Controller
{
  public function __construct() {
    parent::__construct();
    $this->middleware('auth');
  }
    
    public function index() {
      $members = Member::where('status', '<>', 'D')->
        orWhereNull('status')->get();
      return view('members.index', ['members' => $members]);
    }

    public function show($mid) {
      $member = Member::findOrFail($mid);
      return view('members.show', ['member' => $member]);
    }

    public function create() {
      $member = Member::newMember();
      return view('members.create', [
        'title' => 'Member',
        'mode' => 'create',
        'member' => $member,
        'people' => Person::orderBy('fullname')->get(),
        ]);
    }

    public function store(Request $request) {
      $request->validate([
        'person_id'=>'required',
        'regno'=>'required',
      ]);
  
      // field values required for all types of receipts
      $member = new Member([
        'person_id' => $request->get('person_id'),
        'pledge' => $request->get('pledge'),
        'status' => $request->get('status'),
        'regno' => $request->get('regno'),
        'appdate' => $request->get('appdate'),
        'regdate' => $request->get('regdate'),
      ]);
  
      //return view('members.show', ['member' => $member]);
      $member->save();
      return redirect()->route('members.index')
                ->with('success','Member added successfully');
    }

    public function destroy($id)
    {
      $member = Member::findOrFail($id);
      $member->delete();
      return redirect()->route('members.index')
            ->with('success','Member deleted successfully');
    }

    public function edit($id)
    {
      $member = Member::findOrFail($id);
      return view('members.create', [
        'title' => 'Member',
        'mode' => 'edit',
        'member' => $member,
        'people' => Person::orderBy('fullname')->get(),
        ]);
    }

    public function update(Request $request, $id) {
      $request->validate([
        'person_id'=>'required',
        'regno'=>'required',
      ]);
  
      $member = Member::findOrFail($id);
      $member->fill([
        'person_id' => $request->get('person_id'),
        'pledge' => $request->get('pledge'),
        'status' => $request->get('status'),
        'appdate' => $request->get('appdate'),
        'regdate' => $request->get('regdate'),
      ]);
  
      //return view('members.show', ['member' => $member]);
      $member->save();
      return redirect()->route('members.index')
                ->with('success','Member updated successfully');
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
