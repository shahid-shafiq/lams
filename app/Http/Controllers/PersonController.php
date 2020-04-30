<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;

class PersonController extends Controller
{
  public function index() {
    return Person::all();
  }

  public function show($id) {
    $person = Person::findOrFail($id);
    return $person;
  }

  /*
  public function index($memberId) {
    Description::ofMember($memberId);
  }
  */
}
