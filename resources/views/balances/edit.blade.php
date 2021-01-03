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
            <a class="btn btn-primary" href="{{ route('balances.index') }}">{{__('Back')}}</a>
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
                <strong>{{__('Opening')}}:</strong>
                <input type="decimal" name="opening" id="opening" value="{{$balance->opening}}" class="form-control" placeholder="{{__('Opening')}}">
            </div>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <strong>{{__('Income')}}:</strong>
                <input type="decimal" name="income" id="income" value="{{$balance->income}}" class="form-control" placeholder="{{__('Income')}}">
            </div>
        </div>

        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <strong>{{__('Expenses')}}:</strong>
                <input type="decimal" name="expense" id="expense" value="{{$balance->expense}}" class="form-control" placeholder="{{__('Expenses')}}">
            </div>
        </div>

        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <strong>{{__('Balance')}}:</strong>
                <input type="decimal" name="balance" id="balance" value="{{$balance->balance}}" class="form-control" placeholder="{{__('Balance')}}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3 text-center">
            <div class="form-group">
                <button id="recalc" type="button" class="btn btn-primary">{{__('Reclculate')}}</button>
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 text-center">
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
            </div>
        </div>
    </div>
</form>

<script>

$(document).ready(function() {
    $('#recalc').click(function() {
        let open = Math.floor($('#opening').val());
        let income = <?= $sums->inc->isum ?>;
        let expense = <?= $sums->exp->esum ?>;
        let balance = open + income - expense;
        /*
        console.log('Recalculating...');
        console.log('Income is ' + income);
        console.log('Exoense is ' + expense);
        console.log('Balance is ' + balance);
        */
        $('#income').val(income);
        $('#expense').val(expense);
        $('#balance').val(balance);
    });
});

</script>

@endsection