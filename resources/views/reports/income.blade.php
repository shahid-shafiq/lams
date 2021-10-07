@extends('reports.layout')

@section('content')

  <?php 
    use App\Custom\UrduNumber;
  ?>

<?php
  $showseq = ($profile->receipt_seqno != 0);
  $seq = 1; 
?>

{{ ($showseq) ? "Show" : "Not" }}
<div class="row">
<table id="myTable" class="table table-striped table-bordered table-hover table-sm">
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
  </tbody>
</table>
</div>

@endsection

@section('pdflink')
<a target="_blank" href="{{ route('reports.income', 'pdf') }}" class="btn btn-primary btn-sml">PDF</a>
@endsection