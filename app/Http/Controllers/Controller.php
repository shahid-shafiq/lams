<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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

        session(['user.name' => 'admin']);
        session(['period.id' => '92']);
        session(['site.id' => '1']);

        //$this->pid = session()->get('period.id');
        $this->pid = $request->session()->get('period.id');
        $this->sid = $request->session()->get('site.id');
        return $next($request);
      });
    }
}