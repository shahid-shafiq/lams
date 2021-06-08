<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;

class PersonController extends Controller
{
  public function __construct() {
    parent::__construct();
    //$this->middleware('auth');
    //app()->setLocale('ur_PK');
  }

  public function index() {
    return view('people.index', ['title' => 'Persons', 'people' => Person::all()]);
  }

  public function show($id) {
    $person = Person::findOrFail($id);
    return view('people.show', [
      'title' => 'Person',
      'person' => $person]);
  }

  public function create() {
    $person = new Person();
    return view('people.create', [
      'title' => 'Person',
      'mode' => 'create',
      'member' => App()->request->get('member') == 1,
      'person' => $person
      ]);
  }

  public function store(Request $request) {
    $request->validate([
      'fullname'=>'required',
      'mobile'=>'required',
      //''=>'required'
    ]);

    // field values required for all types of receipts
    $person = new Person([
      'fullname' => $request->get('fullname'),
      'address' => $request->get('address'),
      'city' => $request->get('city'),
      'mobile' => $request->get('mobile'),
      'fathername' => $request->get('fathername'),
      'altaddress' => $request->get('altaddress'),
      'gender' => $request->get('gender'),
      'email' => $request->get('email'),
      'contact' => $request->get('contact'),
    ]);

    //return view('people.show', ['person' => $person]);
    $person->save();

    if ($request->get('addmember') == '__new__') {
      return redirect()->route('members.create', 'person='.$person->id);
    } else {
      return redirect()->route('persons.index')
              ->with('success','Person added successfully');
    }
    
  }

  public function edit($id) {
    $person = Person::findOrFail($id);
    return view('people.create', ['title'=>'Person', 'mode' => 'edit', 'person' => $person]);
  }

  public function update(Request $request, $id) {
    $request->validate([
      'fullname'=>'required',
      'mobile'=>'required',
      //''=>'required'
    ]);

    // field values required for all types of receipts
    $person = Person::findOrFail($id);
    $person->fill([
      'fullname' => $request->get('fullname'),
      'address' => $request->get('address'),
      'city' => $request->get('city'),
      'mobile' => $request->get('mobile'),
      'fathername' => $request->get('fathername'),
      'altaddress' => $request->get('altaddress'),
      'gender' => $request->get('gender'),
      'email' => $request->get('email'),
      'contact' => $request->get('contact'),
    ]);

    //return view('people.show', ['person' => $person]);
    $person->save();
    return redirect()->route('persons.index')
              ->with('success','Person added successfully');

  }

  public function destroy($id) {
    $person = Person::findOrFail($id);
    $person->delete();
    return redirect()->route('persons.index')
              ->with('success','Person added successfully');
  }
}
