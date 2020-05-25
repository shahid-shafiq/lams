<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

  public $timestamps = false;
  
  protected $fillable = [
    'person_id', 'pledge', 'status', 'regno', 
    'appdate', 'regdate'
  ];

    public function person() {
      return $this->belongsTo('App\Person');
    }

    public function receipts() {
      return $this->hasMany('App\Receipt', 'm_id')->orderBy('no', 'desc');
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
      $member->regno = Member::nextRegno();
      return $member;
    }

    public static function memberListNames() {
      $mlist = Member::where('status', '<>', 'D')->
        orWhereNull('status')->
        join('people', 'people.id', 'members.person_id')->
        select('members.regno', 'people.fullname')->
        orderBy('people.fullname')->get();
      return $mlist;
    }

    public static function memberListReg() {
      $mlist = Member::where('status', '<>', 'D')->
        orWhereNull('status')->
        join('people', 'people.id', 'members.person_id')->
        select('members.regno', 'people.fullname')->
        orderBy('members.regno')->get();
      return $mlist;
    }
}
