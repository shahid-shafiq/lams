<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

  public $timestamps = true;
  
  const CREATED_AT = 'created';
  const UPDATED_AT = 'modified';

  public $table = "membersext";
  
  protected $fillable = [
    'pledge', 'status', 'regno', 'fathername', 'contact', 'altaddress',
    'appdate', 'regdate', 'fullname', 'address', 'city', 'mobile', 'email', 'gender'
  ];

    
    public function receipts() {
      return $this->hasMany('App\Receipt', 'm_id', 'regno')->where('income_id', '=', '2');// ->orderBy('rdate', 'desc');
    }

    public static function nextRegno() {
      $row = Member::orderBy('regno', 'desc')
        ->limit(1)->get();

      //echo $row[0]->regno;
      if ($row == null || $row->count() == 0) return 1;
      else return $row[0]->regno + 1;
    }

    public static function newMember() {
      $member = new Member();
      $member->regdate = date('Y-m-d');
      $member->appdate = $member->regdate;
      $member->pledge = 100;
      $member->status = 'A';
      $member->regno = Member::nextRegno();
      return $member;
    }

    public static function memberListNames() {
      $mlist = Member::where('status', '<>', 'D')->
        orWhereNull('status')->
        select('regno', 'fullname')->
        orderBy('fullname')->get();
      return $mlist;
    }

    public static function memberListReg() {
      $mlist = Member::where('status', '<>', 'D')->
        orWhereNull('status')->
        select('regno', 'fullname')->
        orderBy('regno')->get();
      return $mlist;
    }
}
