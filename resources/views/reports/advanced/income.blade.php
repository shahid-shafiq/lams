@extends('reports.advanced')

@php
use App\Custom\UrduNumber;
use Carbon\Carbon;

$showseq = ($profile->receipt_seqno != 0);
$seq = 1;

@endphp


@section('filter')

@if ($filter != null):

<div class="container">

<script>
$(document).ready(function(){

  $('#brange').on('click', function(e){
    if ($(this).is(':checked')) {
      console.log('Receipt checked.');

      // enable controls
      $('#frange').prop("disabled", false);
      $('#lrange').prop("disabled", false);
    } else {
      console.log('Receipt cleared.');

      // disable controls
      $('#frange').prop("disabled", true);
      $('#lrange').prop("disabled", true);
    }
  });

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
<?php if ($filter->brange): ?>  
  $('#brange').click();
<?php endif; ?>

<?php if ($filter->bperiod): ?>  
  $('#bperiod').click();
<?php endif; ?>

<?php if ($filter->bdate): ?>  
  $('#bdate').click();
<?php endif; ?>


});
</script>

<form action="{{ route('reports.advanced.income') }}" method="POST">
    {{ csrf_field() }}
  <div class="form-row mt-3">
    <div class="form-group col-sm-2">
      <input type="checkbox" id="brange" name="brange"/>
      <label class="form-label" for="frange">{{__('Receipts')}}</label>
    </div>
    <div class="form-group col-sm-2">
      <input type="number" class="form-control" id="frange" name="frange" value="{{$filter->frange}}" placeholder="First" disabled >
    </div>
    <div class="form-group col-sm-2">
      <input type="number" class="form-control" id="lrange" name="lrange" value="{{$filter->lrange}}" placeholder="Last" disabled >
    </div>
  </div>

  <div class="form-row">
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
{{-- dd($filter) --}}
  <div class="form-row">
    <div class="form-group col-md-1">
      <input type="checkbox" id="infaaq" name="infaaq" {{$filter->infaaq ? "checked" : ""}} />
      <label for="fdate">{{__('Infaaq')}}</label>
    </div>
    <div class="form-group col-md-1">
      <input type="checkbox" id="fee" name="fee" {{$filter->fee ? "checked" : ""}}/>
      <label for="fdate">{{__('Fee')}}</label>
    </div>
    <div class="form-group col-md-1">
      <input type="checkbox" id="special" name="special" {{$filter->special ? "checked" : ""}}/>
      <label for="fdate">{{__('Special')}}</label>
    </div>
    <div class="form-group col-md-1">
      <input type="checkbox" id="sale" name="sale" {{$filter->sale ? "checked" : ""}}/>
      <label for="fdate">{{__('Sale')}}</label>
    </div>
    <div class="form-group col-md-1">
      <input type="checkbox" id="other" name="other" {{$filter->other ? "checked" : ""}}/>
      <label for="fdate">{{__('Other')}}</label>
    </div>
  </div>

  <div class="p-3">
    <button type="submit" class="btn btn-primary">{{ 'Apply' }}</button>
    <a target="_blank" href="{{ route('reports.advanced.income', 'pdf') }}" class="btn btn-primary btn-sml">PDF</a>
  </div>
</form>

</div>

@endif
@endsection


@section('content')

<table id="--myTable" class="table table-striped table-bordered table-hover table-sm">
  <thead class="thead-dark">
  <tr>
  @if ($showseq)
    <th>{{__('No')}}</th>
  @endif
    <th>{{__('Receipt No.')}}</th>
    <th>{{__('Date')}}</th>
    <th>{{__('Title')}}</th>
    <th>{{__('Description')}}</th>
    <th>{{__('Amount')}}</th>
  </tr>
  </thead>
  <tbody style="font-size:0.9rem">
  @if ($receipts->count() > 0)
  @foreach ($receipts as $receipt)
  <tr>
  @if ($showseq)
    <td>{{ $seq }}</td>
  @endif
    <td>{{ $receipt->no }}</td>
    <td>{{ $receipt->rdate }}</td>
    <td>{{ $receipt->title }}</td>
    <td>{{ $receipt->description }}</td>
    <td>{{ $receipt->amount }}
      <x-payicon size="5" payment="{{$receipt->payment->id }}"/>
    </td>
  </tr>

<?php 
  $seq += 1; 
?>
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

@section('pdflink')
<a target="_blank" href="{{ route('reports.income', 'pdf') }}" class="btn btn-primary btn-sml">PDF</a>
@endsection