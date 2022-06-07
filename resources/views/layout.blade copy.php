<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  
  <title>AKQ - {{ $title ?? '' }}</title>

  <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


  <script src="{{ asset('/js/main.js') }}"></script>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="#">
    <img style="width:28px;" src="{{ asset('images/logo.png') }}" />
    <span class="text-light">AKQ</span>
  </a>
  @auth
  <a class="text-white" href="{{ route('profile') }}">
  <i class="material-icons">account_circle</i>
  </a>
  <span class="ml-2 text-white bold"><strong>{{ Auth::user()->username }}</strong></span>
  <span class="ml-2 text-white bold"><strong>{{ Auth::user()->site->title }}</strong></span>
  <span class="ml-2 text-primary"><strong>{{ Auth::user()->profile->period->title }}</strong></span>
  @endauth
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="main-navigation">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('receipts.index') }}">Receipts</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('bills.index') }}">Bills</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('members.index') }}">Members</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('reports') }}">Reports</a>
      </li>
@auth
<?php
$ismanager = Auth::user()->role == 'admin' || Auth::user()->role == 'manager';
?>
@if ($ismanager)
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin') }}">Admin</a>
      </li>
@endif
@endauth
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"><i class="material-icons">power_settings_new</i></a>
      </li>
    </ul>
  </div>
</nav>

@section('sidebar')

@show
  
<div class="container">
    @yield('content')
</div>
   
   <!-- fixed-bottom bg-dark text-light text-center 
   <div id="copyright">&copy; Copyright 2020 Anjuman Khaddam ul Quran Islamabad</div>
   
   -->
<footer class="footer">
  <div class="fixed-bottom bg-dark text-light text-center">
  <span class="d-md-none" style="font-size: 0.7rem">Copyright &copy; 2020 Anjuman Khaddam ul Quran Islamabad</span>
  <span class="d-none d-md-inline" id="copyright">Copyright &copy; 2020 Anjuman Khaddam ul Quran Islamabad</span>
</footer>

</body>
</html>
