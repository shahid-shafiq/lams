@extends('reports.layout')

@section('content')

  <?php 
    use App\Custom\UrduNumber;
  ?>

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
  @foreach ($bills as $bill)
  <tr>
    <td>{{ $bill->no }}</td>
    <td>{{ $bill->bdate }}</td>
    <td>{{ $bill->title }}</td>
    <td>{{ $bill->description }}</td>
    <td>{{ $bill->amount }}
      <x-payicon size="5" payment="{{$bill->payment->id }}"/>
    </td>
  </tr>
  @endforeach
  </tbody>
</table>
@endsection

@section('pages')
<div style="padding-left:1rem">
{{ $bills->links() }}
</div>
@endsection

@section('pdflink')
<a target="_blank" href="{{ route('reports.vouchers', 'pdf') }}" class="btn btn-primary btn-sml">PDF</a>
@endsection