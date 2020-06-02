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


@section('sidebar')

@show
  
<div style="display:flex; align-items: center; width:100%; height:100vh; background-color:#ccc">
  <div class='container col-8 col-md-6 p-0 align-middle' style='
    border: 1px solid #eee;
    box-shadow: 3px 3px 5px #888888; 
    background-color:#eee'>
    <nav class="navbar navbar-expand navbar-dark bg-dark">
      <img style="width:21px;" src="images/logo.png" />
      <span class="text-light">AKQ</span>
    </nav>
    <div class="row justify-content-center" style="padding-left:0; margin-left:0; margin-right:0rem">
      @yield('content')
    </div>
    <footer class="flex-bottom bg-dark text-light text-center" style="font-size:0.75rem">
      <div id="copyright">&copy; Copyright 2020 AKQ Islamabad</div>
    </footer>
  </div>
</div>


</body>
</html>
