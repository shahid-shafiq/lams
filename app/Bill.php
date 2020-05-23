<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
  const CREATED_AT = 'created';
  const UPDATED_AT = 'modified';
  protected $table = 'bills';
  protected $fillable = [
    'no', 'bdate', 'title', 'description', 'amount',
    'payment_id', 'expense_id', 'account_id', 'department_id',
    'period_id', 'site_id'
  ];

  public function payment() {
    return $this->belongsTo('App\Payment');
  }

  public function department() {
    return $this->belongsTo('App\Department');
  }

  public function account() {
    return $this->belongsTo('App\Account');
  }

  public function expense() {
    return $this->belongsTo('App\Expense');
  }

  public static function currDate($sid, $pid) {
    $row = Bill::where(
      ['period_id' => $pid, 'site_id' => $sid])
      ->orderBy('no', 'desc')
      ->limit(1)->get();
    
    if ($row == null || $row->count() == 0) return date('Y-m-d');
    else return $row[0]->bdate;
  }

  public static function nextNumber($sid, $pid) {
    $row = Bill::where(
      ['site_id' => $sid, 'period_id' => $pid])
      ->orderBy('no', 'desc')
      ->limit(1)->get();

    if ($row == null || $row->count() == 0) return 1;
    else return $row[0]->no + 1;
  }

  public static function newBill($sid, $pid) {
      $bill = new Bill();
      $bill->department_id = $sid;
      $bill->site_id = $sid;
      $bill->period_id = $pid;     
      $bill->no = Bill::nextNumber($sid, $pid);
      $bill->bdate = Bill::currDate($sid, $pid);
      $bill->department_id = 1;
      $bill->payment_id = 1;
      $bill->expense_id = 1;
      $bill->account_id = 1;
      
      return $bill;
  }
}
