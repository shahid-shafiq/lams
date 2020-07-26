<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Receipt;
use App\Member;
use Carbon\Carbon;

class Infaaq extends Receipt
{
    protected $table = null;

    public function scopeOfMember($query, $memberId) {
      return $query->where('m_id', $memberId);
    }

    public static function infaaqData($year) {
      $data = array();
      
      if ($year != null) {
        $members = Member::where('status', '<>', 'D')->orWhereNull('status')
          ->join('receipts', 'receipts.m_id', '=', 'members.regno')
          ->orderBy('regno', 'asc')
          ->orderBy('fdate', 'asc')
          ->get();
          
        $crec = 1;
        $cmem = 0;
        foreach ($members as $member) {
          if ($member->regno !== $cmem) {
            if ($cmem !== 0) {
              for ($m = 0; $m < 12; $m++) {
                $row[] = $res[$m];
              }
              //$row[] = $cmem;

              $data[] = $row;
              $crec++;
              if ($crec > 500) break;
            }

            // new member
            $cmem = $member->regno;
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
      }
      return $data;
    }

    public static function infaaqByMember($regno) {
      $receipts = Receipt::where('m_id', $regno)->
        orderBy('fdate')->get();

      $data = array();
      $cy = 0;
      $ym = [0,0,0,0,0,0,0,0,0,0,0,0];
      $nd = null;

      if (count($receipts)) {
        foreach ($receipts as $receipt) {
          $from = Carbon::createFromDate($receipt->fdate);
          $to = Carbon::createFromDate($receipt->tdate);      

          $dt = $from;
          if ($cy === 0) {
            $cy = $dt->year;
          }

          // iterate over date range (fdate -- tdate)
          while ($dt <= $to) {
            $y = $dt->year;
            if ($y !== $cy) {
              $rec['year'] = $cy;
              $rec['month'] = $ym;
              $data[] = $rec;
              $ym = [0,0,0,0,0,0,0,0,0,0,0,0];
              $cy = $y;
            }
            $m = $dt->month;
            $ym[$m-1] = $receipt->no;
              
            $dt->addMonth(1);
          }
          $nd = $dt;
        }

        $rec['year'] = $cy;
        $rec['month'] = $ym;
        $data[] = $rec;
      }

      //$data['member'] = $memberId;
      $inf["member"] = $regno;
      $inf["last"] = $nd;
      $inf["infaaq"] = $data;

      return $inf;
    }
}
