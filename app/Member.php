<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function person() {
      return $this->belongsTo('App\Person');
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
