<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
  const CREATED_AT = 'created';
  const UPDATED_AT = 'modified';
  
  protected $table = 'people';
  
  protected $fillable = [
    'fullname', 'address', 'city', 'mobile', 'email',
    'fathername', 'gender', 'contact', 'altaddress'
  ];
}
