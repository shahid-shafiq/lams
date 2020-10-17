@extends('admin.layout')

@section('content')

<div class="container">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6"><h2>{{__('Users')}}</h2></div>
        <div class="col-sm-4">
          <div class="search-box mt-2">
            <i class="material-icons">&#xE8B6;</i>
            <input id="myInput" class="form-control" type="text" placeholder="{{__('Search')}}&hellip;">
          </div>
        </div>
        <div class="pull-right mt-1">
            <a class="btn btn-success" href="{{ route('users.create') }}">{{__('New User')}}</a>
          </div>
      </div>
    </div>
  
  @if ($users->count() < 1)
  <div class="row">
  NO USERS
  </div>
  @else
  <div  style="height:80vh; overflow:auto">

<table id="myTable" class="table table-striped table-bordered table-hover table-sm">
  <thead>
    <tr>
      <th>{{__('Username')}} <i class="fa fa-sort"></i></th>
      <th>{{__('Role')}}</th>
      <th>{{__('Status')}}</th>
      <th>{{__('Period')}}</th>
      <th>{{__('Site')}}</th>
      <th>{{__('Actions')}}</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($users as $user)
    <tr class="data">
      <td>{{ $user->username }}</td>
      <td>{{ $user->role }}</td>
      <td>
        @if ($user->active)<i class="material-icons" style="color:green;">check</i>
        @else<i class="material-icons" style="color:red;">lock_outline</i>
        @endif
      </td>
      <td>{{ $user->period->title }}</td>
      <td>{{ $user->site->title }}</td>
      <td>
        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
        {{-- @csrf  
        @method('DELETE') ---}}
        <!--
        <a href="{{ route('users.show',$user->id) }}" class="view" title="View" data-toggle="tooltip"><i class="material-icons">pageview</i></a>
        -->
        <a href="{{ route('users.edit',$user->id) }}" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">edit</i></a>
        <a href="{{ route('users.destroy',$user->id) }}" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">delete</i></a>

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