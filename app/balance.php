<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
	protected $primaryKey = 'id';
     protected $table = 'balance';
     protected $fillable = array(
 		'customer_id',
 		'balance',

     );
     public $timestamps = true;
}