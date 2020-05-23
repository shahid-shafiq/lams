@extends('layout')

@section('content')

<div class="container">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6"><h2>Members</h2></div>
        <div class="col-sm-4">
          <div class="search-box">
            <i class="material-icons">&#xE8B6;</i>
            <input id="myInput" class="form-control" type="text" placeholder="Search&hellip;">
          </div>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('members.create') }}">New Member</a>
        </div>
      </div>
    </div>
  
  @if ($members->count() < 1)
  <div class="row">
  NO MEMBERS
  </div>
  @else
  <div  style="height:80vh; overflow:auto">

<table id="myTable" class="table table-striped table-bordered table-hover table-sm">
  <thead>
    <tr>
      <th>Regno</th>
      <th>Name <i class="fa fa-sort"></i></th>
      <th>Pledge</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($members as $member)
    <tr class="data">
      <td>{{ $member->regno }}</td>
      <td>{{ $member->person->fullname }}</td>
      <td>{{ $member->pledge }}</td>
      <td>
      <form action="{{ route('members.destroy', $member->id) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <a href="{{ route('members.show', $member->id) }}" class="view" title="View" data-toggle="tooltip"><i class="material-icons">pageview</i></a>
        <a href="{{ route('members.edit', $member->id) }}" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">edit</i></a>
        <input class="material-icons delete btn-outline-danger" style="border:none" type="submit" value="delete"></input>

        
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