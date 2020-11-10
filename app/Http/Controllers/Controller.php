<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Site;
use App\Period;

use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $pid;
    protected $sid;

    /*
    public function __construct() {
      parent::__construct();

      $this->middleware(function($request, $next) {
        $this->pid = session()->get('period.id');
        $this->sid = session()->get('site.id');
        return $next($request);
      });
    }
    */

    public function __construct() {

      $this->middleware(function($request, $next) {

        //echo Auth::user();
        if (Auth::user()) {
          
        } else {
          //session(['user.name' => 'admin']);
          //session(['period.id' => '94']);
          //session(['site.id' => '2']);
        }

        //$this->pid = session()->get('period.id');
        $this->pid = $request->session()->get('period.id');
        $this->sid = $request->session()->get('site.id');
        return $next($request);
      });
    }

    public function setSite($id) {
      session(['site.id' => $id]);
      session(['site' => Site::find($id)]);
    }

    public function setPeriod($id) {
      session(['period.id' => $id]);
      session(['period' => Period::find($id)]);
    }

    public function setLocale($locale) {
      session(['user.locale' => $locale]);
    }

    
}
