@extends('bills.layout')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Laravel Demo</h2>
        </div>
        <div class="pull-right">
        <a class="btn btn-success" href="{{ route('bills.create') }}">New Bill</a>
        </div>
    </div>
</div>

  <div class="flex-center position-ref">
    <div class="content">
      <table class="table table-bordered">
        <tr>
          <th>Id</th>
          <th>Date</th>
          <th>Title</th>
          <th>Description</th>
          <th>Amount</th>
        </tr>
        @foreach ($bills as $bill)
        <tr>
          <td>{{ $bill->id }}</td>
          <td>{{ $bill->bdate }}</td>
          <td>{{ $bill->title }}</td>
          <td>{{ $bill->description }}</td>
          <td>{{ $bill->amount }}</td>
        </tr>
        @endforeach
      </table>
      <div class="links">
      </div>
    </div>
  </div>
  

@endsection