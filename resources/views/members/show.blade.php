@extends('layout')

@section('content')

{{-- $member --}}

<div class="container">

<div class="row">
    <div class="col-xs-1 col-sm-1 col-md-1">
        <div class="form-group">
        @if ($member->gender == 2)
            <img src="{{ asset('/images/icons8-female-user-64.png')}}"/>
        @else
            <img src="{{ asset('/images/icons8-male-user-64.png')}}"/>
        @endif
        </div>
    </div>
    <div class="col-xs-7 col-sm-7 col-md-7 margin-tb">
        <div class="">
            <h2>{{__('Member')}}</h2>
        </div>
    </div>
    
    <div class="col-xs-3 col-sm-3 col-md-3 margin-tb p-1">
        <div class="d-inline">
        @if ($prev)
            <a class="btn btn-sm btn-info" href="{{ route('members.show', $prev->id) }}"> {{__('Prev')}}</a>
        @else
            <a class="btn btn-sm btn-secondary disabled" href="#"> {{__('Prev')}}</a>
        @endif
        </div>
        <div class="d-inline">
        @if ($next)
            <a class="btn btn-sm btn-info" href="{{ route('members.show', $next->id) }}"> {{__('Next')}}</a>
        @else
            <a class="btn btn-sm btn-secondary disabled" href="#"> {{__('Next')}}</a>
        @endif
            
        </div>
        <div class="d-inline">
            <a class="btn btn-sm btn-primary" href="{{ route('members.index') }}"> {{__('Back')}}</a>
        </div>
    </div>
</div>

<div class="row">
<div class="col">

<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>{{__('Registration No')}}:</strong>
            {{ sprintf("AKQ/M/%03d", $member->regno) }}
        </div>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>{{__('Infaaq')}}:</strong>
            {{ $member->pledge }}
        </div>
    </div>
</div>

@if ($member->regdate)
<div class="row">
    <div class="col-xs-8 col-sm-8 col-md-8">
        <div class="form-group">
            <strong>{{__('Registration Date')}}:</strong>
            {{ $member->regdate }}
        </div>
    </div>

    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>{{__('Application Date')}}:</strong>
            {{ $member->appdate }}
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>{{__('Name')}}:</strong>
            {{ $member->fullname }}
        </div>
    </div>

@if ($member->fathername)
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>{{__("Father's Name")}}:</strong>
            {{ $member->fathername }}
        </div>
    </div>
@endif

    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>{{__('Mobile')}}:</strong>
            {{ $member->mobile }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-9 col-sm-9 col-md-9">
        <div class="form-group">
            <strong>{{__('Address')}}:</strong>
            {{ $member->address }}
        </div>
    </div>

    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <strong>{{__('City')}}:</strong>
            {{ $member->city }}
        </div>
    </div>
</div>

<div class="row">
    
</div>

@if ($member->email)
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{__('Email')}}:</strong>
            {{ $member->email }}
        </div>
    </div>
</div>
@endif

</div>
<?php 
//dump($infaaq['last'])
?>
<div class="col mt-5">
<?php
if (count(['infaaq'])) {
    $ms = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
foreach ($infaaq['infaaq'] as $item) {
?>
<div style="font-size:9px; height:17px;">
    <div>
        {{ $item['year'] }}
        <?php
        $mi = 0;
        foreach ($item['month'] as $m) {
            
        ?>
        <div class="-month" style="
        border:1px solid;
        margin:0; padding:0;
        width:15px;height:15px;
        display:inline-block;
        border-color:
        {{ $m === 0 ? 'red' : 'green' }}
        ;
        background-color:
        {{ $m === 0 ? 'red' : 'green' }}
        ;"
        tooltop="{{ $m }}" data-toggle="tooltip" title="{{ $ms[$mi] }}">&nbsp;</div>
        <?php
            $mi += 1;
        }
        ?>
    </div>
</div>
<?php
}
}
?>

</div>
</div>

@if ($member->receipts->count())
<div class="row">
    <div class="col-xs-7 col-sm-7 col-md-7 margin-tb">
        <div class="">
            <h2>{{__('Infaaq Info')}}</h2>
        </div>
    </div>

    <div class="col-xs-3 col-sm-3 col-md-3 margin-tb">
        <div class="">
            <a class="btn btn-sm btn-primary" href="{{ route('receipts.create') }}">{{__('New Infaaq')}}</a>
        </div>
    </div>
</div>



<div class="row">

<div class="col-xs-10 col-sm-10 col-md-10 margin-tb">
    <table class="table table-striped table-bordered table-hover table-sm">
        <thead>
            <tr style="background-color : rgba(0,0,0,0.15)">
                <th scope="row" width="15%"><?= __('Date') ?></th>
                <th scope="row" width="12%"><?= __('Receipt No.') ?></th>
                <th scope="row" width="*"><?= __('Description') ?></th>
                <th scope="row" width="15%"><?= __('Infaaq From') ?></th>
                <th scope="row" width="15%"><?= __('Infaaq To') ?></th>
                <th scope="row" width="10%"><?= __('Amount') ?></th>
            </tr>
        </thead>
        
        <tbody>
        @foreach ($member->receipts as $receipt)
            <tr>
                <td><?= ($receipt->rdate) ?></th>
                <td><?= ($receipt->no) ?></th>
                <td><?= ($receipt->description) ?></th>
                <td><?= ($receipt->fdate) ?></th>
                <td><?= ($receipt->tdate) ?></th>
                <td><?= ($receipt->amount)  ?></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif

</div>

</div>

@endsection