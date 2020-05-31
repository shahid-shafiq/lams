<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        return view('auth.login', 
        ['title' => 'Login',
        'autherror' => $request->get('error')]);
    }
    
    public function logout() {
        Auth::logout();
        return redirect()->route('home');
    }
    
    public function authenticate(Request $request) {
        if (Auth::attempt([
            'username' => $request->get('username'), 
            'password' => $request->get('password'),
            'active' => 1
            ])) {

            $user = Auth::user();

            if ($user->profile) {
                $user->profile->period_id = $user->period_id;
                $user->profile->save();
            }

            session(['user.name' => $user->username]);
            session(['period.id' => $user->period_id]);
            session(['site.id' => $user->site_id]);

            return redirect()->intended(route('home'));
        } else {
            //echo "Invalid username/password.";
            //echo $request;
            return redirect(route('login', ['error' => 1]));
        }
    }
}
