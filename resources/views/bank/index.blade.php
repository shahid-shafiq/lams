@extends('admin.layout')

@section('content')

<div class="container">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6"><h2>{{__($title)}}</h2></div>
        <div class="col-sm-4">
          <div class="search-box mt-1">
            <i class="material-icons">&#xE8B6;</i>
            <input id="myInput" class="form-control" type="text" placeholder="{{__('Search')}}&hellip;">
          </div>
        </div>
        <div class="pull-right mt-1">
            <a class="btn btn-success" href="{{ route('bank.create') }}">{{__('New Transaction')}}</a>
        </div>
      </div>
    </div>
  
  @if ($trans->count() < 1)
  <div class="row">
  NO TRANSACTIONS
  </div>
  @else


  <div style="height:80vh; overflow:auto">
    <table id="myTable" class="table table-striped table-bordered table-hover table-sm">
      <thead>
        <tr>
          <th></th>
          <th>{{__('Date')}}</th>
          <th>{{__('Description')}}</th>
          <th>{{__('From')}}</th>
          <th>{{__('To')}}</th>
          <th>{{__('Reference')}}</th>
          <th>{{__('Amount')}}</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $idx = 0;
      ?>
      @foreach ($trans as $tr)
      <?php
        $idx = $idx + 1;
        $desc = $tr->descrition;
        if (!$desc) {
          if ($tr->source->code == 'inc') {
            $desc = "Infaaq received in bank";
          } else if ($tr->target->code == 'exp') {
            $desc = "Payment made from bank";
          } else {
            $desc = "Auto description";
          }
        }
      ?>
        <tr class="data">
          <td>{{ $idx }}</td>
          <td>{{ $tr->trans_date }}</td>
          <td>{{ $desc }}</td>
          <td>{{ $tr->source->code . ' (' . $tr->from_account . ')' }}</td>
          <td>{{ $tr->target->code . ' (' . $tr->to_account . ')' }}</td>
          <td>{{ $tr->ref }}</td>
          <td>{{ $tr->amount }}</td>
      </tr>
      @endforeach
      </tbody>
    </table>
  <div>
</div>
@endif
</div>

<script>
  $(document).ready(function() {
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr.data").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    function refresh(obj) { self.location.search = '?filter='+ obj.value; }
  });
    
  console.log('Ok');
</script>

@endsection