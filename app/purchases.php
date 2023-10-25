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
		'tare',
		'moist',
        'net',
		'type',
	    'total',
	    'amtpay',
	    'remarks',
     );

    public function commodityName(){
	    return $this->hasMany('App\Commodity','id','commodity_id');
	}
}
