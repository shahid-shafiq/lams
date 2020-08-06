<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acctrans extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    protected $table = 'acctrans';

    protected $fillable = [
        'trans_date', 'description', 'amount',
        'from_account', 'to_account', 'ref', 
        'period_id', 'site_id'
    ];

    public function Source() {
        return $this->belongsTo('App\Acctype', 'from_account');
    }

    public function Target() {
        return $this->belongsTo('App\Acctype', 'to_account');
    }
}
