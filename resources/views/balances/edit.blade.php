@extends('admin.layout')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
        <h2>
            Edit Balance
        </h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('balances.index') }}"> Back</a>
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

<form action="{{ route('balances.update', $balance->id) }}" method="POST">
@method('PATCH')
{{ csrf_field() }}

<div class="row">
        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <strong>Opening:</strong>
                <input type="decimal" name="opening" value="{{$balance->opening}}" class="form-control" placeholder="{{__('Opening')}}">
            </div>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <strong>Income:</strong>
                <input type="decimal" name="income" value="{{$balance->income}}" class="form-control" placeholder="{{__('Income')}}">
            </div>
        </div>

        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <strong>Expense:</strong>
                <input type="decimal" name="expense" value="{{$balance->expense}}" class="form-control" placeholder="{{__('Expense')}}">
            </div>
        </div>

        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <strong>Balance:</strong>
                <input type="decimal" name="balance" value="{{$balance->balance}}" class="form-control" placeholder="{{__('Balance')}}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8 col-sm-8 col-md-8 text-center">
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>


@endsection