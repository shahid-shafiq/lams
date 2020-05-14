<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
  public function period() {
    return $this->belongsTo('App\Period');
  }
}
