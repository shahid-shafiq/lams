<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MemberOld;
use App\Receipt;
use App\Person;
use App\Infaaq;

class MemberOldController extends Controller
{
  public function __construct() {
    parent::__construct();
    $this->middleware('auth');
  }
    
    public function index() {
      if (Auth()->user()->role=='admin') {
        $members = Memberold::orderBy('regno' ,'ASC')->get();
      } else {
        //$members = Memberold::get();
        $members = Memberold::where('status', '<>', 'D')->orWhereNull('status')->orderBy('regno' ,'ASC')->get();
      }
      
      //$members = Memberold::get();
      return view('members.index', ['title' => 'Members', 'members' => $members]);
    }

    public function show($mid) {
      $member = Memberold::with('receipts')->findOrFail($mid);
      $member->receipts = $member->receipts->sortByDesc('fdate');
      $infaaq = Infaaq::infaaqByMember($member->regno);

      $prev = Memberold::find($mid-1);
      $next = Memberold::find($mid+1);

      return view('members.show', [
        'title' => 'Member', 
        'member' => $member,
        'prev' => $prev,
        'next' => $next,
        'infaaq' => $infaaq]);
    }

    public function create() {
      $member = Memberold::newMember();

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
      $member = Memberold::findOrFail($id);
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
      $member = Memberold::findOrFail($id);
      //$member->delete();
      return redirect()->route('members.index')
            ->with('success','Member removed successfully');
    }

    public function edit($id)
    {
      $member = Memberold::findOrFail($id);
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
  
      $member = Memberold::findOrFail($id);
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
      $member = Memberold::findOrFail($mid);
      $person = Person::findOrFail($member->person_id);
      return $person;
    }

    public function infaaq($mid) {
      $member = Memberold::findOrFail($mid);
      $receipts = Receipt::where('m_id', $mid)->get();
      return $receipts;
    }
}
