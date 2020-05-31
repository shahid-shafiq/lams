@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
          @if ($mode == 'edit')
          <h2>Edit User</h2>
          @else
              <h2>Create New User</h2>
          @endif
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
</div>

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
   
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{ $user }}

@if ($mode == 'edit')
<form action="{{ route('users.update', $user->id) }}" method="POST">
@method('PATCH')
@else
<form action="{{ route('users.store') }}" method="POST">
@endif
    {{ csrf_field() }}

<div class="row">
  <div class="col-xs-8 col-sm-8 col-md-8 p-3">
    <div class="form-group">
      <strong>Username:</strong>
      <input type="text" name="username" class="form-control" placeholder="Username" value="{{$user->username}}"
      @if ($mode == 'edit')
        readonly 
      @endif
      >
    </div>
    <div class="form-group">
      <strong>Password:</strong>
      <input type="password" name="password" class="form-control" value="{{ $user->password }}" placeholder="Password">
    </div>
    <div class="form-group">
      <strong>Language:</strong>
      <input type="text" name="locale" class="form-control" value ="{{$user->locale}}" placeholder="Language">
    </div>
    <div class="form-group">
      <strong>USer Status:</strong>
      <div class="form-check form-check-inline ml-5">
        <input class="form-check-input" type="radio" name="active" id="radio1" value="1" {{ $user->active ? 'checked' : ''}}>
        <label class="form-check-label" for="radio1">Active</label>
      </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="active" id="radio2" value="0" {{ !$user->active ? 'checked' : ''}}>
      <label class="form-check-label" for="radio2">Inactive</label>
    </div>
    </div>
    <div class="form-group">
        <strong>Site:</strong>
        <select type="select" name="site" class="form-control">
        @foreach ($sites as $item)
          <option value="{{$item->id}}"
          {{ $item->id == $user->site_id ? 'selected' : ''}}
          >{{$item->title}}</option>
        @endforeach
        </select>
    </div>
    <div class="form-group">
        <strong>Period:</strong>
        <select type="select" name="period" class="form-control">
        @foreach ($periods as $item)
          <option value="{{$item->id}}"
          {{ $item->id == $user->period_id ? 'selected' : ''}}
          >{{$item->title}}</option>
        @endforeach
        </select>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <button type="submit" class="btn btn-primary">{{ $mode == 'edit' ? 'Update' : 'Submit' }}</button>
  </div>
</div>
        

@endsection