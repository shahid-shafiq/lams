@extends('layout')

@section('title', 'Receipt')

@section('sidebar')
  @parent

@endsection  

@section('content')
    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3 margin-tb">
            <div class="">
                <h2>Receipts</h2>
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 margin-tb">
            <div class="">
                <a class="btn btn-sm btn-primary" href="{{ route('receipts.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>No:</strong>
                {{ $receipt->no }}
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Date:</strong>
                {{ $receipt->rdate }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Title:</strong>
                {{ $receipt->title }}
            </div>
        </div>

        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <strong>Description:</strong>
                {{ $receipt->description }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Department:</strong>
                {{ $receipt->department->title }}
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Amount:</strong>
                {{ $receipt->amount }}
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Payment:</strong>
                {{ $receipt->payment->title }}
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Income:</strong>
                {{ $receipt->income->title }}
            </div>
        </div>

        @if ($receipt->income_id === 3)
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Account:</strong>
                {{ $receipt->account_id }}
            </div>
        </div>
        @endif
    </div>

    @if ($receipt->income_id === 2)
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Memeber:</strong>
                {{ sprintf("AKQ/M/%'.03d", $receipt->member->regno) }}
                {{ $receipt->member->person->fullname }}
                <?php 
                //print($receipt->member); 
                ?>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>From:</strong>
                {{ $receipt->fdate }}
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>To:</strong>
                {{ $receipt->tdate }}
            </div>
        </div>
    </div>
    @endif

@endsection