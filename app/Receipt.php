<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Receipt extends Model
{
  const CREATED_AT = 'created';
  const UPDATED_AT = 'modified';

  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'no', 'title', 'description', 'amount',
      'income_id', 'account_id', 'site_id', 'period_id',
      'rdate', 'department_id', 'payment_id',
      'fdate', 'tdate', 'm_id'
  ];

  public function payment() {
    return $this->belongsTo('App\Payment');
  }

  public function department() {
    return $this->belongsTo('App\Department');
  }

  public function fee() {
    return $this->belongsTo('App\Account');
  }

  public function income() {
    return $this->belongsTo('App\Income');
  }

  public function member() {
    return $this->belongsTo('App\Member', 'm_id', 'regno');
  }

  public static function currDate($sid, $pid) {
    $row = Receipt::where(
      ['site_id' => $sid, 'period_id' => $pid])
      ->orderBy('no', 'desc')
      ->limit(1)->get();

    if ($row == null || $row->count() == 0) return date('Y-m-d');
    else return $row[0]->rdate;
  }

  public static function nextNumber($sid, $pid) {
      $row = Receipt::where(
        ['site_id' => $sid, 'period_id' => $pid])
        ->orderBy('no', 'desc')
        ->limit(1)->get();

      if ($row == null || $row->count() == 0) return 1;
      else return $row[0]->no + 1;
  }

  public static function newReceipt($sid, $pid) {
      $receipt = new Receipt();
      $receipt->department_id = $sid;
      $receipt->site_id = $sid;
      $receipt->period_id = $pid;     
      $receipt->no = Receipt::nextNumber($sid, $pid);
      $receipt->rdate = Receipt::currDate($sid, $pid);
      $receipt->department_id = 1;
      $receipt->payment_id = 1;
      $receipt->income_id = 1;
      $receipt->account_id = 1;
      
      return $receipt;
  }

  public static function infaq($receipt, $request) {
      $receipt->title = '';
      $receipt->description = '';
      $receipt->account = 1;
  }

  public static function periodIncome($sid, $pid) {
      $income = Receipt::
        groupBy(['income_id', 'department_id'])
        ->select(['income_id', 'department_id', DB::Raw('sum(amount) as income_sum')])
        ->where(['period_id' => $sid, 'site_id' => $pid])
        ->get();
      
      $isum = Receipt::
              where(['period_id' => $pid, 'site_id' => $sid])
              ->sum('amount');
      
      $income->isum = $isum;
      
      return $income;
  }

/*
select r.department_id, r.account_id, c.title, sum(r.amount) from receipts r
left join courses c on r.account_id = c.id
where site_id = 4 and period_id = 88
group by r.account_id, r.departfeeDetailment_id
order by r.department_id, r.account_id;
 * /

  public function feeDetail($pid, $site) {
      $feeid = 3;
      $query = $this->find();
      $fee = $query
              //->contain(['Departments', 'Incomes'])
              ->select([
                  'department_id', 'account_id',
                  'c.title', 'd.title',
                  'sum' => $query->func()->sum('amount')])
              ->join([
                  'c' => [
                      'table' => 'courses', 
                      'type' => 'INNER', 
                      'conditions' => 'c.id = Receipts.`account_id`']
              ])
              ->join([
                  'd' => [
                      'table' => 'departments', 
                      'type' => 'INNER', 
                      'conditions' => 'd.id = Receipts.`department_id`']
              ])
              ->where(['Receipts.income_id' => $feeid, 'Receipts.period_id' => $pid, 'Receipts.site_id' => $site])
              ->group(['department_id', 'account_id',])->all();
        
      return $fee;
  }


  public function datestr($da) {
      $ds = $da['year'] . '-' . $da['month'] . '-01';
      return new \DateTime($ds);
      //return \DateTime::createFromFormat('Y-m-d', $ds);
  }

  public function infaqArray($year, $ayanats, &$res) {
      //$res = ['0','0','0','0','0','0','0','0','0','0','0','0'];
      
      foreach ($ayanats as $ayanat) {
          $from = new DateTime($ayanat->fromdate);
          $to = new DateTime($ayanat->todate);
          $int = \DateInterval::createFromDateString('1 month');
          $period = new \DatePeriod($from, $int, $to);
          
          foreach ($period as $dt) {
              $y = $dt->year;
              $m = $dt->month;
              if ($y == $year) {
                  $res[$m] = $ayanat->receipt_id;
              }
          }
      }
      
      return $res;
  }
  */
}
