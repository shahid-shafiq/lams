@extends('layout')

@section('content')

<div class="row">
    <div class="col-xs-3 col-sm-3 col-md-3 margin-tb">
        <div class="">
            <h2>Member</h2>
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 margin-tb">
        <div class="">
            <a class="btn btn-sm btn-primary" href="{{ route('members.index') }}"> Back</a>
        </div>
    </div>
</div>

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
    <div class="col-xs-8 col-sm-8 col-md-8">
        <div class="form-group">
            <strong>Address:</strong>
            {{ $member->person->address }}
        </div>
    </div>

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

<div class="row">
    <div class="col-xs-3 col-sm-3 col-md-3 margin-tb">
        <div class="">
            <h2>Infaaq Info</h2>
        </div>
    </div>

    <div class="col-xs-3 col-sm-3 col-md-3 margin-tb">
        <div class="">
            <a class="btn btn-sm btn-primary" href="{{ route('receipts.create') }}">New Infaaq</a>
        </div>
    </div>


<div class="col-xs-8 col-sm-8 col-md-8 margin-tb">
    <table class="table table-striped table-bordered table-hover table-sm">
        <thead>
            <tr style="background-color : rgba(0,0,0,0.15)">
                <th scope="row" width="17%"><?= __('Date') ?></th>
                <th scope="row" width="12%"><?= __('Receipt No.') ?></th>
                <th scope="row" width="*"><?= __('Description') ?></th>
                <th scope="row" width="10%"><?= __('Amount') ?></th>
            </tr>
        </thead>
        
        <tbody>
        @foreach ($member->receipts as $receipt)
            <tr>
                <td><?= ($receipt->rdate) ?></th>
                <td><?= ($receipt->no) ?></th>
                <td><?= ($receipt->description) ?></th>
                <td><?= ($receipt->amount)  ?></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</div>

@endsection