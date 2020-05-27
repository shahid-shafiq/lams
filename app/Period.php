<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title', 'start', 'end' 
    ];

    public function balance() {
        return $this->hasOne('App\Balance');
      }

}
