@extends('layout')

<?php
 $data = ["A" => 'Alpha', 'B' => 'Beta', 'C'=>'Gamma'];
?>

@section('content')
<div>This is home</div>
<x-select type="B" :data="$data">Cusome Component</x-select>
@endsection