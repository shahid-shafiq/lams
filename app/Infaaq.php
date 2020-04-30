<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Receipt;

class Infaaq extends Receipt
{
    protected $table = null;

    public function scopeOfMember($query, $memberId) {
      return $query->where('m_id', $memberId);
    }
}
