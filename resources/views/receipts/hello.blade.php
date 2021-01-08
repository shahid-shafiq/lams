@extends('layout')

@section('content')

{{ "Courses = ".$courses->count() }}
{{ "Students = ".$students->count() }}<br>
{{ "Course = ".$receipt->account_id }}
{{ "Student = ".$receipt->m_id }}<br>

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Laravel Demo</h2>
        </div>
        <div class="pull-right">
        <a class="btn btn-success" href="{{ route('bills.create') }}">New Bill</a>
        </div>
    </div>
</div>

  <div class="flex-center position-ref">
    <div class="content">
      <form action="{{ route('receipts.hellopost') }}" method="POST">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <strong>{{__('Campus')}}:</strong>
                <select name="campus" id="department" value="{{$receipt->department_id}}" class="form-control"
                data-dependent="course" >
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

            <div class="form-group" style="-display:none">
                <strong>{{__('Course')}}:</strong>
                <select name="course" id="course" value="{{$receipt->account_id}}" class="form-control" 
                  data-campus = 'department' data-dependent="student" >
                  <option value="">{{__('Select Course') }}</option>
                  @foreach ($courses as $item)
                    <option value="{{$item->course_id}}" 
                        @if ($item->course_id == $receipt->account_id)
                            selected
                        @endif
                    >{{$item->title}}</option>
                  @endforeach
                </select>
            </div>

            <div id="account" class="form-group" style="-display:none">
                <strong>{{__('Student')}}:</strong>
                <select name="student" id="student" value="{{$receipt->m_id}}" class="form-control" placeholder="Account">
                  <option value="">{{__('Select Student') }}</option>
                  @foreach ($students as $item)
                    <option value="{{$item->student_no}}" 
                        @if ($item->student_no == $receipt->m_id)
                            selected
                        @endif
                    >{{$item->student_name}}</option>
                  @endforeach
                </select>
            </div>

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
                </datalist>
            </div>


          </div>
          {{ csrf_field() }}

        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                  <button type="submit" class="btn btn-primary">{{ $mode == 'edit' ? 'Update' : 'Submit' }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <button type="button" id="refresh" class="btn btn-info">Refresh</button>
  
<script>
 $(document).ready(function() {
  // set defaults (department / campus)
  setTimeout(() => { init(); }, 500);

// it seems the page is not actually ready and does not fire change events
// so setting half a second timeout before initializing. 
function init() {
  @if ($mode == 'create')
  let cmpid = {{session('site')->id}} 
  console.log('This campus is ' + cmpid);
  $('#department').val('4').change();
  @endif
}

$('#refresh').click(function() {
  console.log('refreshing...');
  console.log('Value of receipt->course = ' + {{ $receipt->account_id }})
  console.log('Value of dummy = ' + $('#dummy').val());
  console.log('value of course control = ' + $('#course').val());
  console.log('value of student control = ' + $('#student').val());
});

// clear contents of courses and students
function clear_cns(cr, st) {
  console.log('Clearing...');
  if (cr) {
    $('#course').empty().append($('<option></option>').text("{{__('Select Course')}}"));
  }

  if (st) {
    $('#student').empty().append($('<option></option>').text("{{__('Select Student')}}"));
  }
}


  // https://www.youtube.com/watch?v=c7-HkztGahM

  // get courses for selected campus 
  $('#department').change(function() {
    console.log('Department change event');
     if ($(this).val() != '') {
       var cmpid = $(this).val();
       var dependent = $(this).data('dependent');
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
                var sel = $('#'+dependent);
                //sel.empty().append($('<option></option>').text("{{__('Select Course')}}"));
                clear_cns(true, true);
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
    console.log('Course change event');
     if ($(this).val() != '') {
       var value = $(this).val();
       var dependent = $(this).data('dependent');
       //var _token = $('input[name="_token"]').val();
       var campus = $(this).data('campus');
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
                var sel = $('#'+dependent);
                var sel2 = $('#memberList');
                //sel.empty().append($('<option></option>').text("{{__('Select Student')}}"));
                clear_cns(false, true);
                $.each(data, function(idx, item) {
                  sel.append(
                    $('<option></option>').attr("value", item.student_no).text(item.student_name))
                  sel2.append(
                    $('<option></option>').attr("value", item.student_name))
                });
            }
        });
     }
   });
 })
</script>

@endsection