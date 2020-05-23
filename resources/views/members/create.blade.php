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
            <a class="btn btn-primary" href="{{ route('members.index') }}"> Back</a>
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
<form action="{{ route('members.update', $member->id) }}" method="POST">
@method('PATCH')
@else
<form action="{{ route('members.store') }}" method="POST">
@endif
    {{ csrf_field() }}
  
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Registration No:</strong>
                <input type="text" readonly name="regno" value="{{$member->regno}}" class="form-control" readonly>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Pledge:</strong>
                <input type="decimal" name="pledge" value="{{$member->pledge}}" class="form-control" placeholder="Infaaq">
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Registration Date:</strong>
                <input type="date" readonly name="regdate" value="{{$member->regdsate}}" class="form-control">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Application Date:</strong>
                <input type="date" name="appdate" value="{{$member->appdate}}" class="form-control">
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Member:</strong>
                <input type="text" name="person" list="peopleList" id="person" class="form-control" placeholder="Person">
                <datalist id="peopleList">
                @foreach ($people as $item)
                <option value="{{$item->fullname}}"></option>
                @endforeach
                </datalist>
            </div>
        </div>
    </div>

    

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>

<script>
 $(document).ready(function() {

  function enableAccount() {
    //$('#account select').prop("disabled", false);  
  }

  function enableFeeReceipt() {
    disableInfaaqReceipt();
    //$('#account').hide();
    $('#course').show();
  }

  function disableFeeReceipt() {
    //$('#account').show();
    $('#course').hide();
  }

  function enableInfaaqReceipt() {
    disableFeeReceipt();
    $('#infaaq').show();
  }

  function disableInfaaqReceipt() {
    $('#infaaq').hide();
  }

  $("#income").on('change', function(e) {
      let idx = e.target.selectedIndex;
      let inc = this.options[idx].text;

      // clear Fee/Infaaq controls
      disableInfaaqReceipt();
      disableFeeReceipt();

      if (inc == 'Fee') {
        console.log('Enabling courses');
        enableFeeReceipt();
      } else if (inc == 'Infaq') {
        enableInfaaqReceipt();
        console.log('Enabling infaaq');
      }
      return;

        console.log( "income changed" );
        console.log(  idx );
        console.log( this.options[e.target.selectedIndex].text );
        console.log( this.options[e.target.selectedIndex].value );
  });

  function selectMember(reg) {

  }

  $('#member').on('change', function(e) {
      let idx = e.target.selectedIndex;
      let inc = this.options[idx].text;

      console.log( this.options[e.target.selectedIndex].text );
      console.log( this.options[e.target.selectedIndex].value );
      $('#regno').val(this.options[idx].value);
  });



  $('#members').on('change', function(e) {
      console.log( e.target.value );
      let mbs = $('#member')[0];
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
      var title = mbo[f].text + ' - ' + mbo[f].value + '';
      $('#title').val(title);
      $('#member').val(mbo[f].value);
      $('#regno').val(mbo[f].value);
  });

  $('#regno').on('change', function(e) {
      let idx = e.target.selectedIndex;
      let inc = this.options[idx].text;

      console.log( this.options[e.target.selectedIndex].text );
      console.log( this.options[e.target.selectedIndex].value );
      $('#member').val(this.options[idx].value);

      let mbs = $('#member')[0];
      let mbo = mbs.options[mbs.selectedIndex];
      $('#members').val(mbo.text);
  });

 });
</script>



@endsection