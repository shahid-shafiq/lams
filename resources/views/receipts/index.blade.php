@extends('layout')

@section('content')

<?php

use App\Custom\Urdutils;
use Carbon\Carbon;

/*
$f = "2020-01";
$d = "2020-03";

$cf = new Carbon($f);
$cd = Carbon::createFromDate($d)->lastOfMonth();
print($cd->toDateString().'<br>');

print(Urdutils::InfaqDescription($cf, $cd)."<br>");

print($cf->toDateString().'<br>');
//print($cd->toDateString());
print($cd->lastOfMonth()->toDateString());
*/
?>

<div class="container">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6"><h2>Receipts</h2></div>
        
        <div class="col-sm-4">
          <div class="search-box">
            <i class="material-icons">&#xE8B6;</i>
            <input id="myInput" class="form-control" type="text" placeholder="Search&hellip;">
          </div>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('receipts.create') }}">New Receipt</a>
        </div>
      </div>
    </div>

  @if ($receipts->count() < 1)
  <div class="row">
  NO RECEIPTS
  </div>
  @else
  <div  style="height:80vh; overflow:auto">

<table id="myTable" class="table table-striped table-bordered table-hover table-sm">
  <tr>
    <th>No</th>
    <th>Date</th>
    <th>Title</th>
    <th>Description</th>
    <th>Amount</th>
    <th>Actions</th>
  </tr>
  @foreach ($receipts as $receipt)
  <tr>
    <td>{{ $receipt->no }}</td>
    <td>{{ $receipt->rdate }}</td>
    <td>{{ $receipt->title }}</td>
    <td>{{ $receipt->description }}</td>
    <td>{{ $receipt->amount }}
      <x-payicon size="5" payment="{{$receipt->payment->id }}"/>
    </td>
    <td>
      <form action="{{ route('receipts.destroy', $receipt->id) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <a href="{{ route('receipts.show', $receipt->id) }}" class="view" title="View" data-toggle="tooltip"><i class="material-icons">pageview</i></a>
        <a href="{{ route('receipts.edit', $receipt->id) }}" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">edit</i></a>
        <input class="material-icons delete btn-outline-danger" style="border:none" 
          onclick="return confirm('Delete record?')" type="submit" value="delete"></input>
        
      </form>
    </td>
  </tr>
  @endforeach
</table>

@endif

@endsection