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
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-3">
  <a class="navbar-brand mr-3" href="#">
  <img style="width:28px;" src="{{ asset('images/logo.png') }}" />
  <span class="text-light">AKQ</span>
  </a>
  @auth
  <a class="navbar-brand mr-3" href="{{ route('profile') }}">
  <i class="material-icons">account_circle</i>
  </a>
  @endauth
  <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="main-navigation">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"><i class="material-icons">power_settings_new</i></a>
      </li>
    </ul>
  </div>
</nav>

@section('sidebar')

@show
{{-- $period->title}}
{{Route::current()->getName() --}}
<div class="container">
  <div class="row">
    <div class="col">
      <div class="d-inline h2">
      {{__('Reports')}} >> 
      </div>
      <div class="d-inline w-20 h4">
      <select class="text-secondary"
      style="
        padding:0.75rem; font-weight:bold;
        background-color:rgba(0,0,0,0.0);
        border: none;
      " 
      onchange = "refresh(this)">
      @foreach ($periods as $item)
      <option value="{{$item->id}}"
      {{ $item->id == $period->id ? 'selected' : ''}}
      >{{$item->title}}
      </option>
      @endforeach
      </select>
      </div>
    </div>
    <script>
        $(function() {});
        function refresh(obj) { self.location.search = '?pid='+ obj.value; }
    </script>
</div>

<div class="row">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a href="{{route('reports')}}" 
            class="nav-link text-secondary {{Route::current()->getName() == 'reports' ? 'active' : ''}}">{{__('Net Profit')}}</a>
        </li>
        <li class="nav-item">
            <a href="{{route('reports.income')}}" 
            class="nav-link text-secondary {{Route::current()->getName() == 'reports.income' ? 'active' : ''}}">{{__('Income')}}</a>
        </li>
        <li class="nav-item">
            <a href="{{route('reports.expense')}}" 
            class="nav-link text-secondary {{Route::current()->getName() == 'reports.expense' ? 'active' : ''}}">{{__('Expenses')}}</a>
        </li>
        <li class="nav-item">
            <a href="{{route('reports.vouchers')}}" 
            class="nav-link text-secondary {{Route::current()->getName() == 'reports.vouchers' ? 'active' : ''}}">{{__('Vouchers')}}</a>
        </li>
        <li class="nav-item">
            <a href="{{route('reports.infaaq')}}" 
            class="nav-link text-secondary {{Route::current()->getName() == 'reports.infaaq' ? 'active' : ''}}">{{__('Infaaq')}}</a>
        </li>
        <li class="float-right">
        @yield('pdflink')
        </li>
        <li class="float-right">
        @yield('pages')
        </li>
    </ul>
  </div>
  <div class="container p-3" style="height:70vh; overflow:auto">
    @yield('content')
  </div>
</div>
<footer class="fixed-bottom bg-dark text-light text-center">
  <div id="copyright">&copy; Copyright 2020 Anjuman Khaddam ul Quran Islamabad</div>
</footer>

</body>
</html>
