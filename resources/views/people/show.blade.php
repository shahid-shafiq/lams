@extends('admin.layout')

@section('content')

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 margin-tb">
        <div class="">
            <h2>{{__('Person')}}</h2>
        </div>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2 margin-tb">
    @if ($person->id)
        <div class="">
            <a class="btn btn-sm btn-primary" href="{{ route('persons.edit',$person->id) }}"> {{__('Edit')}}</a>
        </div>
    </div>
    @endif
    <div class="col-xs-2 col-sm-2 col-md-2 margin-tb">
        <div class="">
            <a class="btn btn-sm btn-primary" href="{{ route('persons.index') }}"> {{__('Back')}}</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
        @if ($person->gender == 2)
            <img src="{{ asset('/images/icons8-female-user-64.png')}}"/>
        @else
            <img src="{{ asset('/images/icons8-male-user-64.png')}}"/>
        @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>{{__('Name')}}:</strong>
            {{ $person->fullname }}
        </div>
    </div>

@if ($person->fathername)
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>{{__('Father Name')}}:</strong>
            {{ $person->fathername }}
        </div>
    </div>
@endif

    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>{{__('Mobile')}}:</strong>
            {{ $person->mobile }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-8 col-sm-8 col-md-8">
        <div class="form-group">
            <strong>{{__('Address')}}:</strong>
            {{ $person->address }}
        </div>
    </div>

    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>{{__('City')}}:</strong>
            {{ $person->city }}
        </div>
    </div>
</div>

@if ($person->altaddress)
<div class="row">
    <div class="col-xs-8 col-sm-8 col-md-8">
        <div class="form-group">
            <strong>{{__('Alternate Address')}}:</strong>
            {{ $person->altaddress }}
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{__('Email')}}:</strong>
            {{ $person->email }}
        </div>
    </div>
</div>

@endsection