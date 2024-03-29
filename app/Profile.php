<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $fillable = [
        'locale', 'receipts_pagesize', 'bills_pagesize', 
        'vouchers_pagesize', 'period_id', 'edit_billno', 'receipt_seqno'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function period() {
        return $this->belongsTo('App\Period');
    }
}
