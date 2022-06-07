<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  @if (app()->getLocale() == 'ur_PK')
  <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/jameel-khushkhat-l" type="text/css"/>
  @endif


  <title>AKQ - {{ $title ?? '' }}</title>

  <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <!-- script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


  <script src="{{ asset('/js/main.js') }}"></script>
  <style>
    body.ur_PK {
      font-family: "JameelKhushkhatLRegular";
      font-size: 1.2em;
    }
  </style>
</head>
<body class="{!! app()->getLocale(); !!}">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <img style="width:18px; margin-right:0.5rem" src="{{ asset('images/logo.png') }}">
  <a class="navbar-brand" href="#">AKQ
  <span class='d-inline d-lg-none text-light'>{{ '- '. ($title ?? '') }}</span>
  </a>
 
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">{{__('Home')}}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('receipts.index') }}">{{__('Receipts')}}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('bills.index') }}">{{__('Bills')}}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('members.index') }}">{{__('Members')}}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('reports') }}">{{__('Reports')}}</a>
      </li>

    @auth
<?php
$isadmin = Auth::user()->role == 'admin';
$ismanager = Auth::user()->role == 'manager';
?>
@if ($ismanager)
  <li class="nav-item">
    <a class="nav-link" href="{{ route('admin') }}">{{__('Manager')}}</a>
  </li>
@elseif ($isadmin)
  <li class="nav-item">
    <a class="nav-link" href="{{ route('admin') }}">{{__('Admin')}}</a>
  </li>
@endif
@endauth
    <!-- 
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
    -->
    </ul>
    @auth
    <div class="ml-2">
      <a class="text-white" href="{{ route('profile') }}" title="{{__('Profile')}}" data_toggle="tooltip"><i class="material-icons">account_circle</i></a>
    </div>
    <div class="ml-2">
      <a class="text-white" href="{{ route('logout') }}" title="{{__('Logout')}}" data_toggle="tooltip"><i class="material-icons">power_settings_new</i></a>
    </div>
    @endauth
  </div>
</nav>
<div class="container-flex bg-secondary">
<?php 
//dump(session('site'));
//dump(session('period'));
//echo session('period')->title;
//$s = json_decode(session('site'));
//echo $s->id;
?>
@auth
<?php
  //$site = Site::find(session('site.id'));
  //$profile = Profile::find(session('profile.id'));
?>
  <div class="ml-3 d-inline">
    <span class="text-white bold"><strong>{{ Auth::user()->username }}</strong></span>
    <!--
    <span class="ml-2 text-white bold"><strong>{{ Auth::user()->site->title }}</strong></span>
    <span class="ml-2 mb-2 text-primary"><strong>{{ Auth::user()->profile->period->title }}</strong></span>
    -->
    <span class="ml-2 text-white bold"><strong>{{ session('site')->title }}</strong></span>
    <span class="ml-2 mb-2 text-primary"><strong>{{ session('period')->title }}</strong></span>
    <span class="ml-2 mb-2 text-info"><strong>{{ App::getLocale() }}</strong></span>  
  </div>
  @endauth
</div>

<div class="content">
    @yield('content')
</div>

<footer class="footer">
  <div class="fixed-bottom bg-dark text-light text-center">
  <span class="d-md-none" style="font-size: 0.7rem">Copyright &copy; 2020 Anjuman Khaddam ul Quran Islamabad</span>
  <span class="d-none d-md-inline" id="copyright">Copyright &copy; 2020 Anjuman Khaddam ul Quran Islamabad</span>
</footer>

</body>
</html>
