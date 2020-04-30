@extends('bills.layout')

@section('title', 'Page Title')

@section('sidebar')
  @parent

  <p>This is appended to the master sidebar.</p>
@endsection  

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Bill</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('bills.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>No:</strong>
                {{ $bill->no }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Date:</strong>
                {{ $bill->date }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Title:</strong>
                {{ $bill->title }}
            </div>
        </div>
    </div>
@endsection