@extends('layout')
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
        @if ($mode == 'edit')
        <h2>Edit Receipt</h2>
        @else
            <h2>Add New Receipt</h2>
        @endif
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('receipts.index') }}"> Back</a>
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
<form action="{{ route('receipts.update', $receipt->id) }}" method="POST">
@else
<form action="{{ route('receipts.store') }}" method="POST">
@endif
    {{ csrf_field() }}
  
     <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>No:</strong>
                @if ($mode == 'edit')
                <input type="text" readonly name="no" value="{{$receipt->no}}" class="form-control" placeholder="Receipt no.">
                @else
                <input type="text" name="no" value="{{$receipt->no}}" class="form-control" placeholder="Receipt no.">
                @endif
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Date:</strong>
                <input type="date" name="rdate" value="{{$receipt->rdate}}" class="form-control" placeholder="receipt date">
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Department:</strong>
                <select name="department" value="{{$receipt->department_id}}" class="form-control" placeholder="Department">
                @foreach ($departments as $item)
                    <option value="{{$item->id}}" 
                        @if ($item->id ===  $receipt->department_id)
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
                <select name="income" id="income" value="{{$receipt->income_id}}" class="form-control" placeholder="Receipt no.">
                @foreach ($incomes as $item)
                    <option value="{{$item->id}}" 
                        @if ($item->id ===  $receipt->income_id)
                            selected
                        @endif
                    >{{$item->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div id="account" class="form-group" style="display:none">
                <strong>Account:</strong>
                <select name="account" value="{{$receipt->account_id}}" class="form-control" placeholder="Account">
                @foreach ($accounts as $item)
                    <option value="{{$item->id}}" 
                        @if ($item->id ===  $receipt->account_id)
                            selected
                        @endif
                    >{{$item->title}}</option>
                @endforeach
                </select>
            </div>

            <div id="course" class="form-group" style="display:none">
                <strong>Course:</strong>
                <select name="course" value="{{$receipt->account_id}}" class="form-control" placeholder="Course">
                @foreach ($courses as $item)
                    <option value="{{$item->id}}" 
                        @if ($item->id ===  $receipt->account_id)
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
                <input type="text" id="title" class="form-control" name="title" placeholder="Title">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <input type="text" class="form-control" name="description" placeholder="Description">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Amount:</strong>
                <input type="decimal" name="amount" value="{{$receipt->amount}}" class="form-control" placeholder="Amount">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Payment:</strong>
                <select name="payment" value="{{$receipt->payment_id}}" class="form-control" placeholder="Payment">
                @foreach ($payments as $item)
                  <option value="{{$item->id}}">{{$item->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
      </div>
        
      <div class="row" id="infaaq" style="display:none">

        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>Member:</strong>
                <input type="text" name="members" list="memberList" id="members" value="{{$receipt->m_id}}" class="form-control" placeholder="Member">
                <datalist id="memberList">
                @foreach ($members as $item)
                  <option value="{{$item->fullname}}"></option>
                @endforeach
                </datalist>
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4" style="display:none">
            <div class="form-group">
                <strong>Member:</strong>
                <select type="select" name="member" id="member" value="{{$receipt->m_id}}" class="form-control" placeholder="Member">
                @foreach ($members as $item)
                  <option value="{{$item->regno}}">{{$item->fullname}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2">
            <div class="form-group">
                <strong>&nbsp;</strong>
                <select type="select" name="regno" id="regno" value="{{$receipt->m_id}}" class="form-control" placeholder="Member">
                @foreach ($regnos as $item)
                  <option value="{{$item->regno}}">{{$item->regno}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>From:</strong>
                <input type="month" name="fdate" value="{{$receipt->fdate}}" class="form-control" placeholder="Date">
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <strong>To:</strong>
                <input type="month" name="tdate" value="{{$receipt->tdate}}" class="form-control" placeholder="Date">
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