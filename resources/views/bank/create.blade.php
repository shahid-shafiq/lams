@extends('admin.layout')
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
        @if ($mode == 'edit')
        <h2>{{__('Edit Transaction')}}</h2>
        @else
            <h2>{{__('Add New Transaction')}}</h2>
        @endif
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('bank.index') }}"> {{__('Back')}}</a>
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
<form action="{{ route('bank.update', $trans->id) }}" method="POST">
@method('PATCH')
@else
<form action="{{ route('bank.store') }}" method="POST">
@endif
    {{ csrf_field() }}
  
     <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Date')}}:</strong>
                <input type="date" name="bdate" value="{{$trans->bdate}}" class="form-control">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Reference')}}:</strong>
                @if ($mode == 'edit')
                <input type="text" readonly name="no" value="{{$trans->no}}" class="form-control" placeholder="{{__('Ref No.')}}">
                @else
                <input type="text" name="no" value="{{$trans->no}}" class="form-control" placeholder="{{__('Ref No.')}}">
                @endif
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div id="account" class="form-group">
                <strong>{{__('Transaction')}}:</strong>
                <select name="trans" class="form-control" placeholder="Transaction">
                @foreach ($translist as $item)
                  <option value="{{$item->id}}" 
                    @if ($item->id ===  $trans->trans_id)
                        selected
                    @endif
                   >{{$item->description}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('Description')}}:</strong>
                <input type="text" class="form-control" name="description" value="{{$trans->description}}" placeholder="{{__('Description')}}">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Amount')}}:</strong>
                <input type="decimal" name="amount" value="{{$trans->amount}}" class="form-control" placeholder="{{__('Amount')}}">
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