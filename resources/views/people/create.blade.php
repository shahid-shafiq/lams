@extends('layout')
  
@section('content')
<div class="container">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
        <h2>
        @if ($mode == 'edit')
            {{__('Edit')}}
        @else
            {{__('Add New')}}
        @endif
            {{__('Person')}}
        </h2>
        </div>
        <div class="pull-right">
        @if ($member ?? '')
            <a class="btn btn-primary" href="{{ route('members.index') }}"> {{__('Back')}}</a> 
        @else
            <a class="btn btn-primary" href="{{ route('persons.index') }}"> {{__('Back')}}</a>
        @endif
        </div>
    </div>
</div>
   
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

@if ($mode == 'edit')
<form action="{{ route('persons.update', $person->id) }}" method="POST">
@method('PATCH')
@else
<form action="{{ route('persons.store') }}" method="POST">
@endif
    {{ csrf_field() }}
  
    @if ($member ?? '')
    <input type="hidden" name="addmember" id="addmember" value="__new__">
    @endif

    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Name')}}:</strong>
                <input type="text" name="fullname" value="{{$person->fullname}}" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__("Father's Name")}}:</strong>
                <input type="text" name="fathername" value="{{$person->fathername}}" class="form-control" placeholder="Father's name">
            </div>
        </div>

        <div class="col-xs-10 col-sm-10 col-md-10">
            <div class="form-group">
                <strong>{{__('Address')}}:</strong>
                <input type="text" name="address" value="{{$person->address}}" class="form-control" placeholder="Address">
            </div>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2">
            <div class="form-group">
                <strong>{{__('City')}}:</strong>
                <input type="text" name="city" value="{{$person->city}}" class="form-control" placeholder="City">
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Mobile')}}:</strong>
                <input type="text" name="mobile" value="{{$person->mobile}}" class="form-control" placeholder="Mobile">
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Email')}}:</strong>
                <input type="email" name="email" value="{{$person->email}}" class="form-control" placeholder="Email">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('Alternate address')}}:</strong>
                <input type="text" name="altaddress" value="{{$person->altaddress}}" class="form-control" placeholder="Address">
            </div>
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2">
            <div class="form-group">
                <strong>{{__('Gender')}}:</strong>
                <select name="gender" value="{{$person->gender}}" class="form-control" placeholder="City">
                    <option value='1' {{$person->gender == 1 ? 'selected' : ''}}>{{__('Male')}}</option>
                    <option value='2' {{$person->gender == 2 ? 'selected' : ''}}>{{__('Female')}}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">{{ $mode == 'edit' ? 'Update' : 'Submit' }}</button>
        </div>
    </div>
</form>

</div>
@endsection