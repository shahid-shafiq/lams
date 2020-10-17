@extends('admin.layout')

@section('content')

<div class="container">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6"><h2>{{__('People')}}</h2></div>
        <div class="col-sm-4">
          <div class="search-box mt-2">
            <i class="material-icons">&#xE8B6;</i>
            <input id="myInput" class="form-control" type="text" placeholder="{{__('Search')}}&hellip;">
          </div>
        </div>
        <div class="pull-right mt-1">
            <a class="btn btn-success" href="{{ route('persons.create') }}">{{__('New Person')}}</a>
        </div>
      </div>
    </div>
  
  @if ($people->count() < 1)
  <div class="row">
  NO PERSONS
  </div>
  @else
  <div  style="height:80vh; overflow:auto">

<table id="myTable" class="table table-striped table-bordered table-hover table-sm">
  <thead>
    <tr>
      <th>ID</th>
      <th>{{__('Name')}} <i class="fa fa-sort"></i></th>
      <th>{{__('Mobile')}}</th>
      <th>{{__('Address')}}</th>
      <th>{{__('City')}}</th>
      <th>{{__('Actions')}}</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($people as $person)
    <tr class="data">
      <td>{{ $person->id }}</td>
      <td>{{ $person->fullname }}</td>
      <td>{{ $person->mobile }}</td>
      <td>{{ $person->address }}</td>
      <td>{{ $person->city }}</td>
      <td>
        <form action="{{ route('persons.destroy', $person->id) }}" method="POST">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <a href="{{ route('persons.show',$person->id) }}" class="view" title="View" data-toggle="tooltip"><i class="material-icons">pageview</i></a>
          <a href="{{ route('persons.edit',$person->id) }}" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">edit</i></a>

          <input class="material-icons btn-outline-danger" style="border:none" 
            onclick="return confirm('Delete record?')" type="submit" value="delete_outline" title="Delete" data-toggle="tooltip">
          </input>
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