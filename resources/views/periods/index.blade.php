@extends('admin.layout')

@section('content')

<div class="container">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6"><h2>Periods</h2></div>
        <div class="col-sm-4">
          <div class="search-box">
            <i class="material-icons">&#xE8B6;</i>
            <input id="myInput" class="form-control" type="text" placeholder="Search&hellip;">
          </div>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('periods.create') }}">New Period</a>
        </div>
      </div>
    </div>
  
  @if ($periods->count() < 1)
  <div class="row">
  NO PERIODS
  </div>
  @else
  <div  style="height:80vh; overflow:auto">

<table id="myTable" class="table table-striped table-bordered table-hover table-sm">
  <thead>
    <tr>
      <th>ID</th>
      <th>Title <i class="fa fa-sort"></i></th>
      <th>Duration</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($periods as $period)
    <tr class="data">
      <td>{{ $period->id }}</td>
      <td>{{ $period->title }}</td>
      <td>{{ $period->start . '-' . $period->end }}</td>
      <td>
        <form action="{{ route('periods.destroy', $period->id) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <a href="{{ route('periods.show',$period->id) }}" class="view" title="View" data-toggle="tooltip"><i class="material-icons">pageview</i></a>
        <a href="{{ route('periods.edit',$period->id) }}" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">edit</i></a>
        <input class="material-icons delete btn-outline-danger" style="border:none" 
          onclick="return confirm('Delete record?')" type="submit" value="delete"></input>

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