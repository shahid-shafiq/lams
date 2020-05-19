@extends('layout')
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
        @if ($mode == 'edit')
        <h2>Edit Bill</h2>
        @else
            <h2>Add New Bill</h2>
        @endif
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('bills.index') }}"> Back</a>
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
<form action="{{ route('bills.update', $bill->id) }}" method="POST">
@else
<form action="{{ route('bills.store') }}" method="POST">
@endif
    {{ csrf_field() }}
  
     <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>No:</strong>
                @if ($mode == 'edit')
                <input type="text" readonly name="no" value="{{$bill->no}}" class="form-control" placeholder="Receipt no.">
                @else
                <input type="text" name="no" value="{{$bill->no}}" class="form-control" placeholder="Receipt no.">
                @endif
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Date:</strong>
                <input type="date" name="rdate" value="{{$bill->bdate}}" class="form-control" placeholder="receipt date">
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Department:</strong>
                <select name="department" class="form-control" placeholder="Department">
                @foreach ($departments as $item)
                    <option value="{{$item->id}}" 
                        @if ($item->id ===  $bill->department_id)
                            selected
                        @endif
                    >{{$item->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Income:</strong>
                <select name="income" id="income" class="form-control" placeholder="Receipt no.">
                @foreach ($expenses as $item)
                    <option value="{{$item->id}}" 
                        @if ($item->id ===  $bill->expense_id)
                            selected
                        @endif
                    >{{$item->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div id="account" class="form-group">
                <strong>Account:</strong>
                <select name="account" class="form-control" placeholder="Account">
                @foreach ($accounts as $item)
                  <option value="{{$item->id}}" 
                    @if ($item->id ===  $bill->account_id)
                        selected
                    @endif
                   >{{$item->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Title:</strong>
                <input type="text" id="title" class="form-control" name="title" value="{{$bill->title}}" placeholder="Title">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <input type="text" class="form-control" name="description" value="{{$bill->description}}" placeholder="Description">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Amount:</strong>
                <input type="decimal" name="amount" value="{{$bill->amount}}" class="form-control" placeholder="Amount">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Payment:</strong>
                <select name="payment" class="form-control" placeholder="Payment">
                @foreach ($payments as $item)
                    <option value="{{$item->id}}" 
                    @if ($item->id ===  $bill->payment_id)
                        selected
                    @endif
                   >{{$item->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
      </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>  
   
</form>
@endsection