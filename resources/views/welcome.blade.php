@extends('layout')

<?php
 $data = ["A" => 'Alpha', 'B' => 'Beta', 'C'=>'Gamma'];
?>

@section('content')


<div>This is home</div>
<x-select type="B" :data="$data">Cusome Component</x-select>

@if (Auth::user())
<div>
<?php
    $user = Auth::user();
    echo $user->username;
?>
    <h2>You are!</h2>
    <p>{{ session()->get('user.name') }}</p>
    <p>{{ session()->get('period.id') }}</p>
    <p>{{ session()->get('site.id') }}</p>
</div>

<a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
@else
<a class="btn btn-primary" href="{{ route('login') }}">Login</a>

@endif

@endsection