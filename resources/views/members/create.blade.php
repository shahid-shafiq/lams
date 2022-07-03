@extends('layout')

@section('content')

<div class="container">

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
        <h2>
        @if ($mode == 'edit')
            {{__('Edit Member')}}
        @else
            {{__('New Member')}}
        @endif
            - {{sprintf("AKQ/M/%03d", $member->regno) }}
        </h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('members.index') }}"> {{__('Back')}}</a>
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

<?php
$newperson = "***" . __('New Person') . "***";
?>

{{-- $member --}}
@if ($mode == 'edit')
<form action="{{ route('members.update', $member->id) }}" method="POST">
@method('PATCH')
@else
<form action="{{ route('members.store') }}" method="POST">
@endif
    {{ csrf_field() }}
  
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <!--strong>{{__('Registration No')}}:</strong-->
                <input type="hidden" readonly name="regno" value="{{$member->regno}}" class="form-control" readonly>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xs-5 col-sm-5 col-md-5">
            <div class="form-group">
                <strong>{{__('Name')}}:</strong>
                <input type="text" name="fullname" value="{{$member->fullname}}" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5">
            <div class="form-group">
                <strong>{{__("Father's Name")}}:</strong>
                <input type="text" name="fathername" value="{{$member->fathername}}" class="form-control" placeholder="Father's name">
            </div>
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2">
            <div class="form-group">
                <strong>{{__('Gender')}}:</strong>
                <select name="gender" value="{{$member->gender}}" class="form-control" placeholder="City">
                    <option value='1' {{$member->gender == 1 ? 'selected' : ''}}>{{__('Male')}}</option>
                    <option value='2' {{$member->gender == 2 ? 'selected' : ''}}>{{__('Female')}}</option>
                </select>
            </div>
        </div>

        <div class="col-xs-10 col-sm-10 col-md-10">
            <div class="form-group">
                <strong>{{__('Address')}}:</strong>
                <input type="text" name="address" value="{{$member->address}}" class="form-control" placeholder="Address">
            </div>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2">
            <div class="form-group">
                <strong>{{__('City')}}:</strong>
                <input type="text" name="city" value="{{$member->city}}" class="form-control" placeholder="City">
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>{{__('Mobile')}}:</strong>
                <input type="text" name="mobile" value="{{$member->mobile}}" class="form-control" placeholder="Mobile">
            </div>
        </div>

        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <strong>{{__('Email')}}:</strong>
                <input type="email" name="email" value="{{$member->email}}" class="form-control" placeholder="Email">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('Alternate address')}}:</strong>
                <input type="text" name="altaddress" value="{{$member->altaddress}}" class="form-control" placeholder="Address">
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>{{__('Pledge')}}:</strong>
                <input type="decimal" name="pledge" value="{{$member->pledge}}" class="form-control" placeholder="Infaaq">
            </div>
        </div>


        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>{{__('Registration Date')}}:</strong>
                <input type="date" readonly name="regdate" value="{{$member->regdate}}" class="form-control">
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>{{__('Application Date')}}:</strong>
                <input type="date" name="appdate" value="{{$member->appdate}}" class="form-control">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">{{ $mode == 'edit' ? __('Update') : __('Submit') }}</button>
        </div>
    </div>
</form>

<script>
 $(document).ready(function() {
    const NEWPERSON = "{{$newperson}}";
    
     // initialize
    @if ($mode == "edit" || $person != null)
        let selinc = $('#person')[0].options[$('#person')[0].selectedIndex].text;
        console.log(selinc);
        $(persons).val(selinc);
    @endif

  $('#persons').on('change', function(e) {
      if (e.target.value == NEWPERSON) {
          console.log('New person addition requested');
          window.location.href = "{{ route('persons.create', 'member=1') }}";
      } else {
        console.log( e.target.value );
        let mbs = $('#person')[0];
        let mbo = mbs.options;
        let f = -1;
        for (i = 0; i < mbo.length; i++) {
            if (e.target.value === mbo[i].text) {
            console.log('Found - ' + mbo[i].value);
            f = i;
            break;
            }
        }

        console.log(f >=0 ? 'FOUND' : 'NOT');
        if (f != -1) {
            let inc = mbo[f].text;
            mbs.value = mbo[f].value;

            //set field related data
            $('#person').val(mbo[f].value);
        }
      }
  });

 });
</script>


</div>

@endsection