@extends('layout')

@section('content')

{{-- $period --}}
<div class="container">
<div class="row">
    <div class="col-xs-3 col-sm-3 col-md-3 margin-tb">
        <div class="">
            <h2>{{__('Period')}}</h2>
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 margin-tb">
        <div class="">
            <a class="btn btn-sm btn-primary" href="{{ route('periods.index') }}">{{__('Back')}}</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>{{__('Title')}}:</strong>
            {{ $period->title }}
        </div>
    </div>

    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>{{__('Start')}}:</strong>
            {{ $period->start }}
        </div>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>{{__('End')}}:</strong>
            {{ $period->end }}
        </div>
    </div>
</div>


@if ($period->balance)
<div class="row">
    <div class="card border-primary w-30 mr-3 shadow">
        <div class="card-header bg-primary text-white">{{__('Opening Balance')}}</div>
        <div class="card-body">
            <h5 class="card-title">{{ ($period->balance->opening) }}</h5>
            <p class="card-text"></p>
        </div>
    </div>

    <div class="card border-success w-30 mr-3 shadow">
        <div class="card-header bg-success text-white">{{__('Total Income')}}</div>
        <div class="card-body">
            <h5 class="card-title">{{ ($period->balance->income) }}</h5>
            <p class="card-text"></p>
        </div>
    </div>

    <div class="card border-danger w-30 mr-3 shadow">
        <div class="card-header bg-danger text-white">{{__('Total Expense')}}</div>
        <div class="card-body">
            <h5 class="card-title">{{ ($period->balance->expense) }}</h5>
            <p class="card-text"></p>
        </div>
    </div>

    <div class="card border-info w-30 mr-3 shadow">
        <div class="card-header bg-info text-white">{{__('Balance')}}</div>
        <div class="card-body">
            <h5 class="card-title">{{ ($period->balance->balance) }}</h5>
            <p class="card-text"></p>
        </div>
    </div>
</div>

@else
    <div class="col-xs-3 col-sm-3 col-md-3 margin-tb">
        <div class="">
            <a class="btn btn-sm btn-primary" href="{{ route('balances.create') }}">{{__('Setup Balance')}}</a>
        </div>
    </div>
@endif

</div>
@endsection