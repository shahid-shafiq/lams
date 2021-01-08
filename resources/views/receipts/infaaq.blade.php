@extends('layout')

@section('content')

<?php

use App\Member;
use Carbon\Carbon;

function println($a1, $a2 = null) {
  print($a1);
  print($a2);
  print("<br>");
}

function prints($a1, $a2 = null) {
  print($a1);
  print($a2);
  print(" ");
}

$data = array();
      
$year = 2021;
if ($year != null) {
  $members = Member::where('status', '<>', 'D')
    ->orWhereNull('status')
    ->join('receipts', 'receipts.m_id', '=', 'members.regno')
    ->where('receipts.income_id', '=', '2')
    //->whereRaw('year(receipts.fdate) >= ?', [$year-5])
    //->whereRaw('year(receipts.tdate) <= ?', [$year+2])
    ->orderBy('regno', 'asc')
    ->orderBy('fdate', 'asc')
    ->get();
      
function dump_members($members) {
  foreach ($members as $m) {
    prints($m->regno);
    println($m->person->fullname);
  }
}

  println("Members ", $members->count());
  //dump_members($members);


  $crec = 1;
  $cmem = 0;
  foreach ($members as $member) {
    if ($member->regno != $cmem) {
      if ($cmem != 0) {
        for ($m = 0; $m < 12; $m++) {
          $row[] = $res[$m];
        }
        //$row[] = $cmem;

        prints($cmem);
        println(json_encode($row));

        $data[] = $row;
        $crec++;
        if ($crec > 500) break;
      }

      // new member
      $cmem = $member->regno;
      //prints($cmem);
      $row = array();

      $row[] = $member->person->fullname;
      $row[] = $member->regno;
      $row[] = $member->person->mobile;
      $row[] = $member->pledge;

      $res = [0,0,0,0,0,0,0,0,0,0,0,0];
    }

    

    if ($member->fdate == null) {
      // skip this record
        continue;
    }

    $from = Carbon::createFromDate($member->fdate);
    $to = Carbon::createFromDate($member->tdate);

    $dt = $from;
    // iterate over date range (fdate-tdate)
    while ($dt <= $to) {
      $y = $dt->year;
      $m = $dt->month;

      if ($y == $year) {
          $res[$m-1] = $member->no;
      }
        
      $dt->addMonth(1);
    }
  }

  // last member entry
  if ($cmem != 0) {
    for ($m = 0; $m < 12; $m++) {
      $row[] = $res[$m];
    }

    prints($cmem);
    println(json_encode($row));

    $data[] = $row;
    $crec++;
  }
}

//dump_data($data);

function dump_data($data) {
  println (count($data));
  $idx = 1;
  foreach ($data as $item) {
    prints($idx++);
    prints($item[1]);
    prints($item[2]);
    println($item[0]);
  }
}
//var_dump($data);
?>

  <button type="button" id="refresh" class="btn btn-info">Refresh</button>
  
<script>
 $(document).ready(function() {
 })
</script>

@endsection