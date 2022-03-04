@extends('layout')
  
@section('content')

<div class="container">

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
        @if ($mode == 'edit')
        <h2>{{__('Edit Bill')}}</h2>
        @else
            <h2>{{__('Add New Bill')}}</h2>
        @endif
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('bills.index') }}"> {{__('Back')}}</a>
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
<form action="{{ route('bills.update', $bill->id) }}" method="POST">
@method('PATCH')
@else
<form action="{{ route('bills.store') }}" method="POST">
@endif
    {{ csrf_field() }}
  
     <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('No')}}:</strong>
                @if ($mode == 'edit' && $profile->edit_billno == false)
                <input type="text" readonly name="no" value="{{$bill->no}}" class="form-control" placeholder="{{__('Bill No.')}}">
                @else
                <input type="text" name="no" value="{{$bill->no}}" class="form-control" placeholder="{{__('Bill No.')}}">
                @endif
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Date')}}:</strong>
                <input type="date" name="bdate" value="{{$bill->bdate}}" class="form-control">
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>{{__('Department')}}:</strong>
                <select name="department" class="form-control" placeholder="Department">
                @foreach ($departments as $item)
                    <option value="{{$item->id}}" 
                        @if ($item->id == $bill->department_id)
                            selected
                        @endif
                    >{{$item->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>{{__('Expense')}}:</strong>
                <select name="expense" id="expense" class="form-control" placeholder="Expense">
                @foreach ($expenses as $item)
                    <option value="{{$item->id}}" 
                        @if ($item->id == $bill->expense_id)
                            selected
                        @endif
                    >{{$item->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div id="accountgrp" class="form-group">
                <strong>{{__('Account')}}:</strong>
                <select name="account" id="account" class="form-control" placeholder="Account">
                @foreach ($accounts as $item)
                  <option value="{{$item->id}}" 
                    @if ($item->id == $bill->account_id)
                        selected
                    @endif
                   >{{$item->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('Title')}}:</strong>
                <input type="text" id="title" class="form-control" name="title" value="{{$bill->title}}" placeholder="Title">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('Description')}}:</strong>
                <input type="text" class="form-control" name="description" value="{{$bill->description}}" placeholder="Description">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Amount')}}:</strong>
                <input type="decimal" name="amount" value="{{$bill->amount}}" class="form-control" placeholder="Amount">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Payment')}}:</strong>
                <select name="payment" class="form-control" placeholder="Payment">
                @foreach ($payments as $item)
                    <option value="{{$item->id}}" 
                    @if ($item->id == $bill->payment_id)
                        selected
                    @endif
                   >{{$item->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
      </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>  
</form>

</div>

<script>
$(document).ready(function() {
// set defaults (department / campus)
setTimeout(() => { init(); }, 500);

// it seems the page is not actually ready and does not fire change events
// so setting half a second timeout before initializing. 
function init() {
    var cmpid;
    console.log('initializing...');
    //return;

    console.log('Mode is <?= $mode ?>');
    @if ($mode == 'edit')
        console.log('Editing bill...');
        //expid = $('#expense').val();
        //actid = $('#account').val();
        //console.log('Editing bill... ex='+expid+', act='+actid);
        //$('#expense').val(expid).change();
        //$('#account').val(actid).change();
    @else
        console.log('New bill...');
        expid = 8;
        $('#expense').val(expid).change();
    @endif
    
  // Check the value of expense type
    const exp = "General";
    let selinc = $('#expense')[0].options[$('#expense')[0].selectedIndex].text;
    console.log('expense is ' + selinc);
    if (selinc != exp) {
        //updateExpenseUI(selinc);     
    }


    console.log('initialized.');
}

function updateExpenseUI(exp) {
    // clear Fee/Infaaq controls

    // enable controls based on the income type

}

function updateAccountsUI(exp) {
    // clear Fee/Infaaq controls
    var value = exp;
    
    console.log("Updating accounts using expense " + value + ".");
    //console.log(campus);

    let apiurl = "{{ url('api/subaccounts') }}"+'/'+value;
    console.log(apiurl);

    $.ajax({
        url: apiurl,
        method : 'get',
        // if method is post
        //data:{select:select, value:value, _token:_token, dependent:dependent},
        success : function(result) {
            //console.log(result);
            let data = result;//JSON.parse(result);
            //console.log(data);
            var sel = $('#account');
            sel.empty().append($('<option></option>').text("{{__('Select Account')}}"));
            //clear_accounts();
            $.each(data, function(idx, item) {
                sel.append(
                $('<option></option>').attr("value", item.id).text(item.title)
                )
            });
        }
    });
}

// clear contents of accounts
function clear_accounts() {
    $('#course').empty().append($('<option value=""></option>').text("{{__('Select Account')}}"));
}

// get accounts for selected expense
$('#expense').change(function() {
    if ($(this).val() != '') {
        var value = $(this).val();

        if ($(this).val() != '') {
        
            console.log("Updating accounts using expense " + value + ".");
            //console.log(campus);

            let apiurl = "{{ url('api/subaccounts') }}"+'/'+value;
            console.log(apiurl);

            $.ajax({
                url: apiurl,
                method : 'get',
                // if method is post
                //data:{select:select, value:value, _token:_token, dependent:dependent},
                success : function(result) {
                    //console.log(result);
                    let data = result;//JSON.parse(result);
                    //console.log(data);
                    var sel = $('#account');
                    sel.empty().append($('<option></option>').text("{{__('Select Account')}}"));
                    //clear_accounts();
                    $.each(data, function(idx, item) {
                        sel.append(
                        $('<option></option>').attr("value", item.id).text(item.title)
                        )
                    });
                }
            });
        }
    }
});

});

</script>




@endsection