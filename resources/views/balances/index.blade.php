@extends('admin.layout')

@section('content')

<div class="container">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6"><h2>{{__('Balances')}}</h2></div>
        <div class="col-sm-4">
          <div class="search-box">
            <i class="material-icons">&#xE8B6;</i>
            <input id="myInput" class="form-control" type="text" placeholder="{{__('Search')}}&hellip;">
          </div>
        </div>
        @if (true | !$current)
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('balances.create') }}">{{__('Setup Balance')}}</a>
        </div>
        @endif
      </div>
    </div>
  
  @if ($balances->count() < 1)
  <div class="row">
  NO BALANCES
  </div>
  @else


  <div style="height:80vh; overflow:auto">
    <table id="myTable" class="table table-striped table-bordered table-hover table-sm">
      <thead>
        <tr>
          <th>{{__('Period')}} <i class="fa fa-sort"></i></th>
          <th>{{__('Opening')}}</th>
          <th>{{__('Income')}}</th>
          <th>{{__('Expense')}}</th>
          <th>{{__('Balance')}}</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      @foreach ($balances as $bal)
        <tr class="data">
          <td>{{ $bal->period ? $bal->period->title : '' }}</td>
          <td>{{ $bal->opening }}</td>
          <td>{{ $bal->income }}</td>
          <td>{{ $bal->expense }}</td>
          <td>{{ $bal->balance }}</td>
          @if ($bal->id)
          <td><a href="{{ route('balances.edit',$bal->id) }}" class="show" title="{{__('Edit')}}" data-toggle="tooltip"><i class="material-icons">edit</i></a></td>
          @endif
      </tr>
      @endforeach
      </tbody>
    </table>
  <div>
</div>
@endif
</div>

@endsection