<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subincome extends Model
{
    //use HasFactory;
    public $timestamps = false;
    public $table = 'subincome';

    public static function subs($inc) {
        return Subincome::where(['income_id' => $inc])->get();
    }
}
