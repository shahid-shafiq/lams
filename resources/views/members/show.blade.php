@extends('layout')

@section('content')

{{-- $member --}}

<div class="container">

<div class="row">
    <div class="col-xs-7 col-sm-7 col-md-7 margin-tb">
        <div class="">
            <h2>Member</h2>
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 margin-tb p-1">
        <div class="d-inline">
        @if ($prev)
            <a class="btn btn-sm btn-info" href="{{ route('members.show', $prev->id) }}"> Prev</a>
        @else
            <a class="btn btn-sm btn-secondary disabled" href="#"> Prev</a>
        @endif
        </div>
        <div class="d-inline">
        @if ($next)
            <a class="btn btn-sm btn-info" href="{{ route('members.show', $next->id) }}"> Next</a>
        @else
            <a class="btn btn-sm btn-secondary disabled" href="#"> Next</a>
        @endif
            
        </div>
        <div class="d-inline">
            <a class="btn btn-sm btn-primary" href="{{ route('members.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="row">
<div class="col">



<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>Registration No:</strong>
            {{ sprintf("AKQ/M/%03d", $member->regno) }}
        </div>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>Infaaq:</strong>
            {{ $member->pledge }}
        </div>
    </div>
</div>

@if ($member->regdate)
<div class="row">
    <div class="col-xs-8 col-sm-8 col-md-8">
        <div class="form-group">
            <strong>Registration Date:</strong>
            {{ $member->regdate }}
        </div>
    </div>

    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>Application Date:</strong>
            {{ $member->appdate }}
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $member->person->fullname }}
        </div>
    </div>

    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>Mobile:</strong>
            {{ $member->person->mobile }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Address:</strong>
            {{ $member->person->address }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4">
        <div class="form-group">
            <strong>City:</strong>
            {{ $member->person->city }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {{ $member->person->email }}
        </div>
    </div>
</div>

</div>
<?php 
//dump($infaaq['last'])
?>
<div class="col mt-5">
<?php
if (count(['infaaq'])) {
foreach ($infaaq['infaaq'] as $item) {
?>
<div style="font-size:9px; height:17px;">
    <div>
        {{ $item['year'] }}
        <?php
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
        tooltop="{{ $m }}">&nbsp;</div>
        <?php
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
            <h2>Infaaq Info</h2>
        </div>
    </div>

    <div class="col-xs-3 col-sm-3 col-md-3 margin-tb">
        <div class="">
            <a class="btn btn-sm btn-primary" href="{{ route('receipts.create') }}">New Infaaq</a>
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
                <th scope="row" width="15%"><?= __('From') ?></th>
                <th scope="row" width="15%"><?= __('To') ?></th>
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