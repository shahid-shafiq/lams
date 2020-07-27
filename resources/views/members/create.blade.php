@extends('layout')
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
        <h2>
        @if ($mode == 'edit')
            Edit
        @else
            Add New
        @endif
            Member - {{sprintf("AKQ/M/%03d", $member->regno) }}
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

{{-- $member --}}
@if ($mode == 'edit')
<form action="{{ route('members.update', $member->id) }}" method="POST">
@method('PATCH')
@else
<form action="{{ route('members.store') }}" method="POST">
@endif
    {{ csrf_field() }}
  
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Registration No')}}:</strong>
                <input type="text" readonly name="regno" value="{{$member->regno}}" class="form-control" readonly>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Pledge')}}:</strong>
                <input type="decimal" name="pledge" value="{{$member->pledge}}" class="form-control" placeholder="Infaaq">
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Registration Date')}}:</strong>
                <input type="date" readonly name="regdate" value="{{$member->regdate}}" class="form-control">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Application Date')}}:</strong>
                <input type="date" name="appdate" value="{{$member->appdate}}" class="form-control">
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Member')}}:</strong>
                <input type="text" name="persons" list="peopleList" id="persons" class="form-control" placeholder="Person">
                <datalist id="peopleList">
                @foreach ($people as $item)
                <option value="{{$item->fullname}}"></option>
                @endforeach
                </datalist>
            </div>
            <div class="form-group" style="display:none">
                <select type="text" name="person_id" id="person" class="form-control">
                @foreach ($people as $item)
                <option value="{{$item->id}}" {{ $item->id == $member->person_id ? 'selected' : '' }} >{{$item->fullname}}</option>
                @endforeach
                </select>
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

     // initialize
    let selinc = $('#person')[0].options[$('#person')[0].selectedIndex].text;
    console.log(selinc);
    $(persons).val(selinc);

  $('#persons').on('change', function(e) {
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

      let inc = mbo[f].text;
      mbs.value = mbo[f].value;
      console.log(f >=0 ? 'FOUND' : 'NOT');

      //set field related data
      $('#person').val(mbo[f].value);
  });

 });
</script>



@endsection