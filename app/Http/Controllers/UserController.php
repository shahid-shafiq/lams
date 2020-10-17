<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
      'locale' => 'en_US',
      'role' => 'user'
    ]);

    return view('users.create', [
      'title' => 'User',
      'mode' => 'create',
      'user' => $user,
      'sites' => Site::get(),
      'periods' => Period::orderBy('id', 'desc')->get(),
    ]);
  }

  public function edit($id) {
    $user = User::findOrFail($id);
    return view('users.create', [
      'title' => 'User',
      'mode' => 'edit',
      'user' => $user,
      'sites' => Site::get(),
      'periods' => Period::orderBy('id', 'desc')->get(),
    ]);
  }

  public function store(Request $request) {
    $user = new User([
      'username' => $request->username,
      'password' => Hash::make($request->password),
      'site_id' => $request->site,
      'period_id' => $request->period,
      'locale' => $request->locale,
      'role' => $request->role,
      'active' => $request->active
    ]);

    $user->save();
    $user->profile()->create([
      'locale' => $request->locale,
      'period_id' => $request->period,
    ]);

    return redirect( route('users.index') );
  }

  public function update(Request $request, $id) {
    $user = User::findOrFail($id);
    $user->fill([
      'site_id' => $request->site,
      'period_id' => $request->period,
      'locale' => $request->locale,
      'role' => $request->role,
      'active' => $request->active
    ]);

    if ($user->password != $request->password) {
      $user->password = Hash::make($request->password);
    }

    $user->save();
    $profile = $user->profile;
    if (!$profile) {
      $user->profile()->create([
        'locale' => $request->locale,
        'period_id' => $request->period,
      ]);
    } else {
      $profile->fill([
        'locale' => $request->locale,
        'period_id' => $request->period,
      ]);
      $profile->save();
    }

    return redirect( route('users.index') );
  }

  public function profile() {
    $periods = Period::orderBy('id', 'desc')->get();
    $sites = Site::get();

    // create profile if not found
    if (Auth::user()->profile == null) {
      Auth::user()->profile()->create([
        'period_id' => $this->pid,
      ]);
    }

    return view('users.profile', [
      'title' => 'Profile',
      'periods' => $periods,
      'sites' => $sites,
      'back' => url()->previous(),
      'site' => Site::find($this->sid),
      'period' => Period::find($this->pid),
      'user' => Auth::user(),
      'locales' => ['en_US' => 'English', 'ur_PK' => 'Urdu'],
    ]);
  }

  public function updateprofile(Request $request) {
    
    $site = $request->get('site');
    $period = $request->get('period');
    $locale = $request->get('locale');

    $this->setPeriod($period);
    if ($site) $this->setSite($site);
    if ($locale) $this->setLocale($locale);

    $profile = Auth::user()->profile;
    if ($profile) {
      $profile->fill([
        'period_id' => $period,
        'receipts_pagesize' => $request->receipt_pagesize,
        'bills_pagesize' => $request->bill_pagesize,
        'vouchers_pagesize' => $request->voucher_pagesize,
        'locale' => $request->locale,
      ]);

      $profile->save();
    }

    return redirect( $request->back );
    //return redirect( route('home') );
  }
}
