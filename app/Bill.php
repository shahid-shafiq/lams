<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
  const CREATED_AT = 'created';
  const UPDATED_AT = 'modified';
  protected $table = 'bills';
  protected $fillable = [
    'no', 'bdate', 'title', 'description', 'amount',
    'payment_id', 'expense_id', 'account_id', 'department_id',
    'period_id', 'site_id'
  ];
}
