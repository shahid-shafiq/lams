@extends('reports.advanced')

@php

use App\Custom\UrduNumber;
use Carbon\Carbon;
 
@endphp


@section('filter')

@if ($filter != null):

<div class="container">

<script>
$(document).ready(function(){

  $('#bperiod').on('click', function(e){
    if ($(this).is(':checked')) {
      console.log('Period checked.');

      // enable controls
      $('#fperiod').prop("disabled", false);
      $('#tperiod').prop("disabled", false);
    } else {
      console.log('Period cleared.');

      // disable controls
      $('#fperiod').prop("disabled", true);
      $('#tperiod').prop("disabled", true);
    }
  });

  $('#bdate').on('click', function(e){
    if ($(this).is(':checked')) {
      console.log('Date checked.');

      // enable controls
      $('#fdate').prop("disabled", false);
      $('#tdate').prop("disabled", false);
    } else {
      console.log('Date cleared.');

      // disable controls
      $('#fdate').prop("disabled", true);
      $('#tdate').prop("disabled", true);
    }
  });

  // initialize state
<?php if ($filter->bperiod): ?>  
  $('#bperiod').click();
<?php endif; ?>

<?php if ($filter->bdate): ?>  
  $('#bdate').click();
<?php endif; ?>

});
</script>

<form action="{{ route('reports.advanced.expense') }}" method="POST">
    {{ csrf_field() }}

  <div class="form-row mt-3">
    <div class="form-group col-md-2">
      <input type="checkbox" id="bperiod" name="bperiod"/>
      <label for="fperiod">{{__('Period')}}</label>
    </div>
    <div class="form-group col-md-2">
      <select id="fperiod" name="fperiod" class="form-control" disabled >
      @foreach ($periods as $item)
      <option value="{{$item->id}}"
      {{ $item->id == $filter->fperiod ? 'selected' : ''}}
      >{{$item->title}}
      </option>
      @endforeach
      </select>
    </div>
    <div class="form-group col-md-2">
      <select id="tperiod" name="tperiod" class="form-control" disabled >
      @foreach ($periods as $item)
      <option value="{{$item->id}}"
      {{ $item->id == $filter->tperiod ? 'selected' : ''}}
      >{{$item->title}}
      </option>
      @endforeach
      </select>
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-2">
      <input type="checkbox" id="bdate" name="bdate" />
      <label for="fdate">{{__('Date')}}</label>
    </div>
    <div class="form-group col-md-3">
      <input disabled type="date" class="form-control" id="fdate" name="fdate" placeholder="Start" value="{{Carbon::createFromDate($filter->fdate)->format('Y-m-d')}}">
    </div>
    <div class="form-group col-md-3">
      <input disabled type="date" class="form-control" id="tdate" name="tdate" placeholder="End" value="{{Carbon::createFromDate($filter->tdate)->format('Y-m-d')}}">
    </div>
  </div>

  <div class="p-3">
    <button type="submit" class="btn btn-primary">{{ 'Apply' }}</button>
    <a target="_blank" href="{{ route('reports.advanced.expense', 'pdf') }}" class="btn btn-primary btn-sml">PDF</a>
  </div>
</form>

</div>

@endif
@endsection


@section('content')

<table id="--myTable" class="table table-striped table-bordered table-hover table-sm">
  <thead class="thead-dark">
  <tr>
    <th>{{__('No')}}</th>
    <th>{{__('Date')}}</th>
    <th>{{__('Title')}}</th>
    <th>{{__('Description')}}</th>
    <th>{{__('Amount')}}</th>
  </tr>
  </thead>
  <tbody style="font-size:0.9rem">
  @if ($bills->count() > 0)
  @foreach ($bills as $bill)
  <tr>
    <td>{{ $bill->period_id . ':' . $bill->no }}</td>
    <td>{{ $bill->bdate }}</td>
    <td>{{ $bill->title }}</td>
    <td>{{ $bill->description }}</td>
    <td>{{ $bill->amount }}
      <x-payicon size="5" payment="{{$bill->payment->id }}"/>
    </td>
  </tr>
  @endforeach
  @else
  <tr>
    <td colspan="5">{{__("NO RECORDS FOUND!")}}
    </td> 
  </tr>
  @endif
  </tbody>
</table>

@endsection
