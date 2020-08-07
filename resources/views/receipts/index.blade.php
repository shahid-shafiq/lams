@extends('layout')


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

@section('sidebar')

@endsection

@section('content')

<div class="container">
  <div class="row p-1 ml-0">
    <div class="col">
      <div class="row">
        <div class="d-none d-lg-inline mr-2"><h2>{{ __('Receipts') }}</h2></div>
        <div class="dropdown ">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ ($filter == 0) ? __('All') :
                (($filter == 2) ? __('Infaaq') : __('Fee'))
                }}
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('receipts.index', 'filter=all') }}">{{__('All')}}
                @if ($filter == 0)
                <i class="material-icons">done</i>
                @endif</a>
                <a class="dropdown-item" href="{{ route('receipts.index', 'filter=infaaq') }}">{{__('Infaaq')}}
                @if ($filter == 2)
                <i class="material-icons">done</i>
                @endif</a>
                <a class="dropdown-item" href="{{ route('receipts.index', 'filter=fee') }}">{{__('Fee')}}
                @if ($filter == 3)
                <i class="material-icons">done</i>
                @endif</a>
                </a>
              </div>
            </div>
        </div>
      </div>
    <!--div class="col">qw</div-->
    <div class="col">
      <div class="search-box mt-1">
        <i class="material-icons">&#xE8B6;</i>
        <input id="myInput" class="form-control" type="text" placeholder="{{__('Search')}}&hellip;">
      </div>
    </div>
    <div class="col text-right">
      <a class="btn btn-success" href="{{ route('receipts.create') }}">{{__('New Receipt')}}</a>
    </div>
  </div>

<!-- Table Row -->
@if ($receipts->count() < 1)
  <div class="row p-1 ml-0">
NO RECEIPTS
  </div>
@else
  <div style="height:80vh; overflow:auto">

  <table id="myTable" class="table table-striped table-bordered table-hover table-sm">
    <tr>
      <th>{{__('No')}}</th>
      <th>{{__('Date')}}</th>
      <th>{{__('Title')}}</th>
      <th>{{__('Description')}}</th>
      <th>{{__('Amount')}}</th>
      <th>{{__('Actions')}}</th>
    </tr>
    @foreach ($receipts as $receipt)
    <tr class="data">
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
  </div>
@endif
</div>

<script>
  $(document).ready(function() {
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr.data").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    function refresh(obj) { self.location.search = '?filter='+ obj.value; }
  });
    
  
  console.log('Ok');
</script>

@endsection