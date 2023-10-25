<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paymentlogs extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'payment_logs';
	protected $fillable = array(
		'logs_id',
		'paymentmethod',
		'checknumber',
		'paymentamount',
	);
	public $timestamps = true;

	public function customerName(){
	    return $this->hasMany('App\Customer','id','logs_id');
	}
}
