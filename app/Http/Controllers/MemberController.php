<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Receipt;
use App\Person;
use App\Infaaq;

class MemberController extends Controller
{
  public function __construct() {
    parent::__construct();
    $this->middleware('auth');
  }
    
    public function index() {
      if (Auth()->user()->role=='admin') {
        $members = Member::orderBy('regno' ,'ASC')->get();
      } else {
        //$members = Member::get();
        $members = Member::where('status', '<>', 'D')->orWhereNull('status')->orderBy('regno' ,'ASC')->get();
      }
      
      //$members = Member::get();
      return view('members.index', ['title' => 'Members', 'members' => $members]);
    }

    public function show($mid) {
      $member = Member::with('receipts')->findOrFail($mid);
      $member->receipts = $member->receipts->sortByDesc('fdate');
      $infaaq = Infaaq::infaaqByMember($member->regno);

      $prev = Member::find($mid-1);
      $next = Member::find($mid+1);

      return view('members.show', [
        'title' => 'Member', 
        'member' => $member,
        'prev' => $prev,
        'next' => $next,
        'infaaq' => $infaaq]);
    }

    public function create() {
      $member = Member::newMember();

      $pid = App()->request->get('person');
      $person = Person::find($pid);
      if ($person != null) {
        $member->person_id = $person->id;
      }

      return view('members.create', [
        'title' => 'Member',
        'mode' => 'create',
        'person' => $person,
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
  
      $debug = false;
      if ($debug) {
        echo "MEMBER<br/>";
        echo $member;
        echo "<br/>REQUEST<br/>";
        echo $request;
        return;
      } else {
        $member->save();
        return redirect()->route('members.index')->with('success','Member added successfully');
      }
      
    }

    public function destroy($id)
    {
      $member = Member::findOrFail($id);
      // the record is only marked as deleted and is not destroyed from DB
      //$member->delete();
      $member->status = 'D';
      $member->save();
  
      //return view('members.show', ['member' => $member]);
      return redirect()->route('members.index')
            ->with('success','Member deleted successfully');
    }

    public function remove($id)
    {
      $member = Member::findOrFail($id);
      //$member->delete();
      return redirect()->route('members.index')
            ->with('success','Member removed successfully');
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
