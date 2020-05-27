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
            Period
        </h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('periods.index') }}"> Back</a>
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
<form action="{{ route('periods.update', $period->id) }}" method="POST">
@method('PATCH')
@else
<form action="{{ route('periods.store') }}" method="POST">
@endif
    {{ csrf_field() }}
  
    <div class="row">
        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <strong>Title:</strong>
                <input type="text" name="title" value="{{$period->title}}" class="form-control" placeholder="Title">
            </div>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <strong>Period Start Date:</strong>
                <input type="date" name="start" value="{{$period->start}}" class="form-control" placeholder="Start">
            </div>
        </div>

        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <strong>Period End Date:</strong>
                <input type="date" name="end" value="{{$period->end}}" class="form-control">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8 col-sm-8 col-md-8 text-center">
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ $mode == 'edit' ? 'Update' : 'Submit' }}</button>
            </div>
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