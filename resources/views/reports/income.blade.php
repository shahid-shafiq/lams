@extends('reports.layout')

@section('content')

  <?php 
    use App\Custom\UrduNumber;
  ?>

<div class="row">
<table id="myTable" class="table table-striped table-bordered table-hover table-sm">
  <thead class="thead-dark">
  <tr>
    <th>No</th>
    <th>Date</th>
    <th>Title</th>
    <th>Description</th>
    <th>Amount</th>
  </tr>
  </thead>
  <tbody style="font-size:0.9rem">
  @foreach ($receipts as $receipt)
  <tr>
    <td>{{ $receipt->no }}</td>
    <td>{{ $receipt->rdate }}</td>
    <td>{{ $receipt->title }}</td>
    <td>{{ $receipt->description }}</td>
    <td>{{ $receipt->amount }}
      <x-payicon size="5" payment="{{$receipt->payment->id }}"/>
    </td>
  </tr>
  @endforeach
  </tbody>
</table>
</div>

@endsection

@section('pdflink')
<a target="_blank" href="{{ route('reports.income', 'pdf') }}" class="btn btn-primary btn-sml">PDF</a>
@endsection