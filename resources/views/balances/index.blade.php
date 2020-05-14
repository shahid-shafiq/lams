@extends('admin.layout')

@section('content')

<div class="container">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-8"><h2>Balances</h2></div>
        <div class="col-sm-4">
          <div class="search-box">
            <i class="material-icons">&#xE8B6;</i>
            <input id="myInput" class="form-control" type="text" placeholder="Search&hellip;">
          </div>
        </div>
      </div>
    </div>
  
  @if ($balances->count() < 1)
  <div class="row">
  NO BALANCES
  </div>
  @else
  <div  style="height:80vh; overflow:auto">

<table id="myTable" class="table table-striped table-bordered table-hover table-sm">
  <thead>
    <tr>
      <th>Period <i class="fa fa-sort"></i></th>
      <th>Opening</th>
      <th>Income</th>
      <th>Expense</th>
      <th>Balance</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($balances as $bal)
    <tr class="data">
      <td>{{ $bal->period->title }}</td>
      <td>{{ $bal->opening }}</td>
      <td>{{ $bal->income }}</td>
      <td>{{ $bal->expense }}</td>
      <td>{{ $bal->balance }}</td>
      <td>
        <form action="{{ route('people.destroy', $bal->id) }}" method="POST">
        {{-- @csrf  
        @method('DELETE') ---}}
        <a href="{{ route('people.show',$bal->id) }}" class="view" title="View" data-toggle="tooltip"><i class="material-icons">pageview</i></a>
        <a href="{{ route('people.edit',$bal->id) }}" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">edit</i></a>
        <a href="{{ route('people.destroy',$bal->id) }}" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">delete</i></a>

        {{ csrf_field() }}
        {{ method_field('DELETE') }}
      </form>
      </td>
  </tr>
  @endforeach
  </tbody>
</table>
  <div>


    </div>
    @endif
  </div>
</div>

<script>
  $(document).ready(function() {
    console.log('JQ - Ok');
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr.data").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
    
  
  console.log('Ok');
</script>

@endsection