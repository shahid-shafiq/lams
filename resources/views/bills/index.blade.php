@extends('layout')

@section('content')

<div class="container">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6"><h2>Bills</h2></div>
        
        <div class="col-sm-4">
          <div class="search-box">
            <i class="material-icons">&#xE8B6;</i>
            <input id="myInput" class="form-control" type="text" placeholder="Search&hellip;">
          </div>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('bills.create') }}">New Bill</a>
        </div>
      </div>
    </div>

  @if ($bills->count() < 1)
  <div class="row">
  NO BILLS
  </div>
  @else
  <div  style="height:80vh; overflow:auto">

<table id="myTable" class="table table-striped table-bordered table-hover table-sm">
  <tr>
    <td>No</td>
    <td>Date</td>
    <td>Title</td>
    <td>Description</td>
    <td>Amount</td>
    <th>Actions</th>
  </tr>
  @foreach ($bills as $bill)
  <tr>
    <td>{{ $bill->no }}</td>
    <td>{{ $bill->bdate }}</td>
    <td>{{ $bill->title }}</td>
    <td>{{ $bill->description }}</td>
    <td>{{ $bill->amount }}
      <x-payicon size="5" payment="{{$bill->payment->id }}"/>
    </td>
    <td>
      <form action="{{ route('bills.destroy', $bill->id) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <a href="{{ route('bills.show',$bill->id) }}" class="view" title="View" data-toggle="tooltip"><i class="material-icons">pageview</i></a>
        <a href="{{ route('bills.edit',$bill->id) }}" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">edit</i></a>
        <input class="material-icons delete btn-outline-danger" style="border:none" 
        onclick="return confirm('Delete record?')" type="submit" value="delete"></input>
        
      </form>
    </td>
  </tr>
  @endforeach
</table>

@endif

@endsection