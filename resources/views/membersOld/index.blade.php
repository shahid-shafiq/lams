@extends('layout')

@section('content')

<div class="container">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6"><h2>{{__('Members')}}</h2></div>
        <div class="col-sm-4">
          <div class="search-box mt-2">
            <i class="material-icons">&#xE8B6;</i>
            <input id="myInput" class="form-control" type="text" placeholder="{{__('Search')}}&hellip;">
          </div>
        </div>
        <div class="pull-right mt-1">
            <a class="btn btn-success" href="{{ route('members.create') }}">{{__('New Member')}}</a>
        </div>
      </div>
    </div>
  
  @if ($members->count() < 1)
  <div class="row">
  NO MEMBERS
  </div>
  @else
  <div  style="height:78vh; overflow:auto">

<table id="myTable" class="table table-striped table-bordered table-hover table-sm">
  <thead>
    <tr>
      <th>{{__('Regno')}}</th>
      <th>{{__('Name')}} <i class="fa fa-sort"></i></th>
      <th>{{__('Pledge')}}</th>
      <th>{{__('Actions')}}</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($members as $member)
  <?php
  $delclass = $member->status === 'D' ? 'text-secondary' : '';
  ?>
    <tr class="data">
      <td class="{{$delclass}}">{{ $member->regno }}</td>
      <td class="{{$delclass}}">{{ $member->person->fullname }}</td>
      <td class="{{$delclass}}">{{ $member->pledge }}</td>
      <td>
      <form action="{{ route('members.destroy', $member->id) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <a href="{{ route('members.show', $member->id) }}" class="view {{$delclass}}" title="View" data-toggle="tooltip"><i class="material-icons">pageview</i></a>
        <a href="{{ route('members.edit', $member->id) }}" class="edit {{$delclass}}" title="Edit" data-toggle="tooltip"><i class="material-icons">edit</i></a>
        @if (Auth::user()->role == 'admin' && $member->status !== 'D')
        <input class="material-icons btn-outline-danger" style="border:none" 
          onclick="return confirm('Delete record?')" type="submit" value="delete_outline" title="Delete" data-toggle="tooltip">
        </input>
        @endif        
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

@auth
@endauth

<script>
  $(document).ready(function() {
    //console.log('JQ - Ok');
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr.data").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>

@endsection