@extends('layout')

@php
use Carbon\Carbon;
@endphp

@section('sidebar')

@endsection
  
@section('content')
<div class="container">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
        @if ($mode == 'edit')
        <h2>{{__('Edit Receipt')}}</h2>
        @else
            <h2>Add New Receipt</h2>
        @endif
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('receipts.index') }}"> {{__('Back')}}</a>
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
@method('PATCH')
@else
<form action="{{ route('receipts.store') }}" method="POST">
@endif
    {{ csrf_field() }}

     <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('No')}}:</strong>
                @if ($mode == 'edit')
                <input type="text" readonly name="no" value="{{$receipt->no}}" class="form-control" placeholder="{{__('Receipt no.')}}">
                @else
                <input type="text" name="no" value="{{$receipt->no}}" class="form-control" placeholder="{{__('Receipt no.')}}">
                @endif
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Date')}}:</strong>
                <input type="date" name="rdate" value="{{$receipt->rdate}}" class="form-control" placeholder="receipt date">
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>{{__('Department')}}:</strong>
                <select name="department" id="department" value="{{$receipt->department_id}}" class="form-control" placeholder="Department">
                @foreach ($departments as $item)
                    <option value="{{$item->id}}" 
                        @if ($item->id == $receipt->department_id)
                            selected
                        @endif
                    >{{$item->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>{{__('Income')}}:</strong>
                <select name="income" id="income" value="{{$receipt->income_id}}" class="form-control">
                @foreach ($incomes as $item)
                    <option value="{{$item->id}}" 
                        @if ($item->id == $receipt->income_id)
                            selected
                        @endif
                    >{{$item->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div id="account" class="form-group" style="display:none">
                <strong>{{__('Account')}}:</strong>
                <select name="account" value="{{$receipt->account_id}}" class="form-control" placeholder="Account">
                @foreach ($accounts as $item)
                    <option value="{{$item->id}}" 
                        @if ($item->id == $receipt->account_id)
                            selected
                        @endif
                    >{{$item->title}}</option>
                @endforeach
                </select>
            </div>

            <div id="course_grp" class="form-group" style="display:none">
                <strong>{{__('Course')}}:</strong>
                <select name="course" id="course" value="{{$receipt->account_id}}" class="form-control" placeholder="Course">
                @foreach ($courses as $item)
                    <option value="{{$item->id}}" 
                        @if ($item->id == $receipt->account_id)
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
                <input type="text" id="title" value="{{$receipt->title}}" class="form-control" name="title" placeholder="Title">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('Description')}}:</strong>
                <input type="text" class="form-control" value="{{$receipt->description}}" name="description" placeholder="Description">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Amount')}}:</strong>
                <input type="decimal" name="amount" value="{{$receipt->amount}}" class="form-control" placeholder="Amount">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>{{__('Payment')}}:</strong>
                <select name="payment" value="{{$receipt->payment_id}}" class="form-control" placeholder="Payment">
                @foreach ($payments as $item)
                  <option value="{{$item->id}}" 
                        @if ($item->id == $receipt->payment_id)
                            selected
                        @endif
                    >{{$item->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
      </div>
        
    <div class="container row" id="infaaqfee" style="-display:none">

        <div class="col-xs-6" id="memberinfo" style="display:none">
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8">
                    <div class="form-group">
                        <strong>{{__('Member')}}:</strong>
                        <?php
                            $memval = "";
                            if ($receipt->member) {
                                $memval = $receipt->member->person->fullname;
                            }
                        ?>
                        <input type="text" name="members" list="memberList" id="members" value="{{ $memval }}" class="form-control" placeholder="Member">
                        <datalist id="memberList">
                        @foreach ($members as $item)
                        <option value="{{$item->fullname}}"></option>
                        @endforeach
                        </datalist>
                    </div>
                </div>

                <div class="col-xs-1 col-sm-1 col-md-1" style="display:none">
                    <div class="form-group">
                        <strong>{{__('Member')}}:</strong>
                        <select type="select" name="member" id="member" value="{{$receipt->m_id}}" class="form-control" placeholder="Member">
                        @foreach ($members as $item)
                        <option value="{{$item->regno}}"
                        {{ $item->regno == $receipt->m_id ? 'selected' : ''}}
                        >{{$item->fullname}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group">
                        <strong>&nbsp;</strong>
                        <select type="select" name="regno" id="regno" value="{{$receipt->m_id}}" class="form-control" placeholder="Member">
                        @foreach ($regnos as $item)
                        <option value="{{$item->regno}}" 
                        {{ $item->regno == $receipt->m_id ? 'selected' : ''}}
                        >{{$item->regno}}</option>
                        
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-8" id="studentinfo" style="display:none">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{__('Student')}}:</strong>
                        <select name="student" id="student" value="{{$receipt->m_id}}" class="form-control" placeholder="Account">
                        <option value="">{{__('Select Student') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-6" id="daterange" style="display:none">
            <div class="container row" >
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>{{__('Infaaq From')}}:</strong>
                        <input type="month" name="fdate" id="fdate" value="{{Carbon::createFromDate($receipt->fdate)->format('Y-m')}}" class="form-control" placeholder="Date">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>{{__('Infaaq To')}}:</strong>
                        <input type="month" name="tdate" id="tdate" value="{{Carbon::createFromDate($receipt->tdate)->format('Y-m')}}" class="form-control" placeholder="Date">
                    </div>
                </div>
            </div>
        </div>
    </div>

        

      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">{{ $mode == 'edit' ? 'Update' : 'Submit' }}</button>
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
  let cmpid = 4;//{{session('site')->id}} 
  console.log('This campus is ' + cmpid);
  $('#department').val(cmpid).change();

  // Check the value of income type
    const inf = "General";
    let selinc = $('#income')[0].options[$('#income')[0].selectedIndex].text;
    console.log(selinc);
    if (selinc != inf) {
        updateIncomeUI(selinc);
        // select correct member values
    }
    console.log($('#fdate, #fdatef'));
}

// clear contents of courses and students
function clear_cns(cr, st) {
  if (cr) {
    $('#course').empty().append($('<option></option>').text("{{__('Select Course')}}"));
  }

  if (st) {
    $('#student').empty().append($('<option></option>').text("{{__('Select Student')}}"));
  }
}

// get courses for selected campus 
$('#department').change(function() {
    if ($(this).val() != '') {
    var cmpid = $(this).val();
    //var dependent = $(this).data('dependent');
    console.log("Updating course using department value " + cmpid);

    let apiurl = "{{ url('api/courses') }}"+'/'+cmpid;
    console.log(apiurl);

    $.ajax({
        url: apiurl,
        method : 'get',
        // if method is post
        //data:{select:select, value:value, _token:_token, dependent:dependent},
        success : function(result) {
            let data = result;//JSON.parse(result);
            //console.log(data);
            // select element for filling courses
            clear_cns(true, true);
            var sel = $('#course');
            $.each(data, function(idx, item) {
                sel.append(
                $('<option></option>').attr("value", item.course_id).text(item.title)
                )
            });

            // select if there is ony one item
            if (data.length == 1) {
                console.log('auto selecting single course');
                $('#course').val(data[0].course_id);
                $('#course').change();
            }
            
        }
    });
    }
});

// get students for selected campus and course
$('#course').change(function() {
    if ($(this).val() != '') {
        var value = $(this).val();
        //var dependent = $(this).data('dependent');
        //var _token = $('input[name="_token"]').val();
        var campus ='department';
        let cmpid = campus ? $('#'+campus).val() : 0;

        console.log("Updating students using campus " + cmpid + " and course " + value);
        //console.log(campus);

        let apiurl = "{{ url('api/students') }}"+'/'+cmpid+'/'+value;
        console.log(apiurl);

        $.ajax({
            // url:" route('dynamic.course') ",
            url: apiurl,
            method : 'get',
            // if method is post
            //data:{select:select, value:value, _token:_token, dependent:dependent},
            success : function(result) {
                //console.log(result);
                let data = result;//JSON.parse(result);
                //console.log(data);
                var sel = $('#student');
                //sel.empty().append($('<option></option>').text("{{__('Select Student')}}"));
                clear_cns(false, true);
                $.each(data, function(idx, item) {
                    sel.append(
                    $('<option></option>').attr("value", item.student_no).text(item.student_name)
                    )
                });
            }
        });
    }
});

// update title based on student selection
$('#student').change(function() {
    if ($(this).val() != '') {
        $('#member').val($(this).val());
        $('#title').val($('#student option:selected').text());
    }
});

function setFromDate(ndt) {
    var ds = ndt.substr(0, 7);
    $('#fdataf').val(ds);
    $('#tdataf').val(ds);
    document.getElementById('fdate').value = ds;
    document.getElementById('tdate').value = ds;
}

function getInfaqDetails(mid) {
    let apiurl = "{{ url('api/infaaq') }}"+'/'+mid;
    console.log(apiurl);

    $.ajax({
        url: apiurl,
        method : 'get',
        success : function(result) {
            console.log(result);
            console.log(result['last']);
            setFromDate(result['last']);
        }
    });
}

function enableAccount() {
    //$('#account select').prop("disabled", false);  
}

function enableFeeReceipt() {
    disableInfaaqReceipt();
    //$('#account').hide();
    $('#course_grp').show();

    $('#infaaqfee').show();
        $('#studentinfo').show();
        $('#daterange').show();
}

function disableFeeReceipt() {
    //$('#account').show();
    $('#course_grp').hide();

    $('#infaaqfee').hide();
        $('#studentinfo').hide();
        $('#daterange').hide();
}

function enableInfaaqReceipt() {
    disableFeeReceipt();
    $('#infaaqfee').show();
        $('#memberinfo').show();
        $('#daterange').show();
}

function disableInfaaqReceipt() {
    $('#infaaqfee').hide();
        $('#memberinfo').hide();
        $('#daterange').hide();
}

function updateIncomeUI(inc) {
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
}

function updateDescriptionByDate(fd, td) {
    fds = fd.getFullYear()+'-'+(fd.getMonth()+1).toString().padStart(2, '0');
    tds = td.getFullYear()+'-'+(td.getMonth()+1).toString().padStart(2, '0');
    console.log(fds);
    console.log(tds);
}

function updateInfaaqDates(fd, td) {
    //console.log(fd);
    //console.log(td);
    fds = fd.getFullYear()+'-'+(fd.getMonth()+1).toString().padStart(2, '0');
    tds = td.getFullYear()+'-'+(td.getMonth()+1).toString().padStart(2, '0');
    document.getElementById('fdate').value = fds;
    document.getElementById('tdate').value = tds;
    updateDescriptionByDate(fd, td);
}

$('#fdate').on('change', function(e) {
    //console.log('from date changed');
    let fd = new Date($('#fdate').val());
    let td = new Date($('#tdate').val());
    if (fd > td) {
        td = fd;
        updateInfaaqDates(fd, td);
    } else {
        updateDescriptionByDate(fd, td);
    }
});

$('#tdate').on('change', function(e) {
    //console.log('to date changed');
    let fd = new Date($('#fdate').val());
    let td = new Date($('#tdate').val());
    if (td < fd) {
        fd = td;
        updateInfaaqDates(fd, td);
    } else {
        updateDescriptionByDate(fd, td);
    }
});

$("#income").on('change', function(e) {
    let idx = e.target.selectedIndex;
    let inc = this.options[idx].text;

    updateIncomeUI(inc);    
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

    // get infaaq details for this member
    console.log('Get infaaq details...');
    getInfaqDetails(mbo[f].value);
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

    var title = mbo.text + ' - ' + mbo.value + '';
    $('#title').val(title);

    console.log('Title set to :: ' + title)
    getInfaqDetails(mbo.value);
});

// end of jquery block
});
</script>



@endsection