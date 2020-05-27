<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
  public function index() {
    return view('users.index', [
      'title' => 'Users',
      'users' => User::all()]);
  }

  public function login() {
    return view('auth.login');
  }

  public function logout() {
    Auth::logout();
    //session()->forget('user.name');
    //session()->forget('perios.id');
    //session()->forget('site.id');
    return redirect()->route('home');
  }

  public function authenticate(Request $request) {
    if (Auth::attempt([
      'username' => $request->get('username'), 
      'password' => $request->get('password')])) {

        $user = Auth::user();

        session(['user.name' => $user->username]);
        session(['period.id' => $user->period_id]);
        session(['site.id' => $user->site_id]);

      return redirect()->intended(route('home'));
    } else {
      echo "Invalid username/password.";
      echo $request;
      return redirect()->route('home');
    }
    
  }
}
