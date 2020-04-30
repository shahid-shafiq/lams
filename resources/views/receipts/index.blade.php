@extends('layout')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Receipts</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('receipts.create') }}">New Receipt</a>
        </div>
    </div>
</div>

@if ($receipts->count() < 1)
<div>
NO RECEIPTS
</div>
@else

<table class="table table-bordered">
  <tr>
    <td>No</td>
    <td>Date</td>
    <td>Title</td>
    <td>Description</td>
    <td>Amount</td>
  </tr>
  @foreach ($receipts as $receipt)
  <tr>
    <td>{{ $receipt->no }}</td>
    <td>{{ $receipt->rdate }}</td>
    <td>{{ $receipt->title }}</td>
    <td>{{ $receipt->description }}</td>
    <td>{{ $receipt->amount }}</td>
    <td>
      <form action="{{ route('receipts.destroy', $receipt->id) }}" method="POST">
        <a class="btn btn-info" href="{{ route('receipts.show',$receipt->id) }}">Show</a>
        <a class="btn btn-primary" href="{{ route('receipts.edit',$receipt->id) }}">Edit</a>
        {{-- @csrf  
        @method('DELETE') ---}}

        {{ csrf_field() }}
        {{ method_field('DELETE') }}
      </form>
    </td>
  </tr>
  @endforeach
</table>

@endif

@endsection