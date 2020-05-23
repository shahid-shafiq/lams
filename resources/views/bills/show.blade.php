@extends('layout')

@section('title', 'Bill')

@section('sidebar')
  @parent

@endsection  

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Bill</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('bills.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>No:</strong>
                {{ $bill->no }}
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Date:</strong>
                {{ $bill->bdate }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Title:</strong>
                {{ $bill->title }}
            </div>
        </div>

        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <strong>Description:</strong>
                {{ $bill->description }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Department:</strong>
                {{ $bill->department->title }}
            </div>
        </div>

       

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Expense:</strong>
                {{ $bill->expense ? $bill->expense->title : '' }}
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Account:</strong>
                {{ $bill->account->title }}
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Amount:</strong>
                {{ $bill->amount }}
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Payment:</strong>
                {{ $bill->payment->title }}
            </div>
        </div>
    </div>
@endsection