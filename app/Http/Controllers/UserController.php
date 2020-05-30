<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Period;
use App\Site;

use Auth;

class UserController extends Controller
{
  public function __construct() {
    parent::__construct();
    $this->middleware('auth');
  }

  public function index() {
    return view('users.index', [
      'title' => 'Users',
      'users' => User::all()]);
  }

  public function create() {
    $user = new User([
      'period_id' => $this->pid,
      'site_id' => $this->sid,
      'locale' => 'en_US'
    ]);
    return view('users.create', [
      'title' => 'User',
      'mode' => 'create',
      'user' => $user,
      'sites' => Site::get(),
      'periods' => Period::orderBy('id', 'desc')->get(),
    ]);
  }

  public function store(Request $request) {
    $user = new User([
      'username' => $request->get('username'),
      'password' => $request->get('password'),
      'site_id' => $request->get('site_id'),
      'period_id' => $request->get('period_id'),
      'locale' => $request->get('locale'),
    ]);

    $user->save();
    return redirect( route('users.index') );
  }

  public function profile() {
    $periods = Period::orderBy('id', 'desc')->get();
    $sites = Site::get();

    return view('users.profile', [
      'title' => 'Profile',
      'periods' => $periods,
      'sites' => $sites,
      'site' => Site::find($this->sid),
      'period' => Period::find($this->pid),
      'user' => Auth::user(),
    ]);
  }

  public function updateprofile(Request $request) {
    
    $site = $request->get('site');
    $period = $request->get('period');

    $this->setPeriod($period);
    $this->setSite($site);

    $profile = Auth::user()->profile;
    if ($profile) {
      $profile->fill([
        'period_id' => $period,
        'receipts_pagesize' => $period,
        'bills_pagesize' => $period,
        'vouchers_pagesize' => $period,
        'locale' => $locale,
      ]);

      $profile->save();
    }

    return redirect( route('home') );
  }
}
