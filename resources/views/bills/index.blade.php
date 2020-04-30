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

<table class="table table-bordered">
  <tr>
    <td>Id</td>
    <td>Date</td>
    <td>Title</td>
    <td>Description</td>
    <td>Amount</td>
  </tr>
  @foreach ($bills as $bill)
  <tr>
    <td>{{ $bill->id }}</td>
    <td>{{ $bill->bdate }}</td>
    <td>{{ $bill->title }}</td>
    <td>{{ $bill->description }}</td>
    <td>{{ $bill->amount }}</td>
    <td>
      <form action="{{ route('bills.destroy', $bill->id) }}" method="POST">
        <a class="btn btn-info" href="{{ route('bills.show',$bill->id) }}">Show</a>
        <a class="btn btn-primary" href="{{ route('bills.edit',$bill->id) }}">Edit</a>
        {{-- @csrf  
        @method('DELETE') ---}}

        {{ csrf_field() }}
        {{ method_field('DELETE') }}
      </form>
    </td>
  </tr>
  @endforeach
</table>

#endsection