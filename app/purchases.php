<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchases extends Model
{
	protected $primaryKey = 'id';
     protected $table = 'purchases';
     protected $fillable = array(
 	    'trans_no',
 	    'customer_id',
 	    'commodity_id',
 	    'sacks',
 	    'ca_id',
 	    'balance',
 	    'partial',
	    'kilo',
	    'price',
	    'total',
	    'amtpay',
	    'remarks',
     );
}
