<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{

  public $timestamps = false;
  
  protected $fillable = [
    'opening', 'income', 'expense', 'balance'
  ];

  public function period() {
    return $this->belongsTo('App\Period');
  }
}
