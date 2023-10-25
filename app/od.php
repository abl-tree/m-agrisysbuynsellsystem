<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class od extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'deliveries';
	protected $fillable = array(
		'outboundTicket',
		'commodity_id',
		'destination',
		'driver_id',
		'company_id',
		'plateno',
		'fuel_liters',
		'allowance',
	);

    public function driver() {
        return $this->hasOne('App\Employee', 'id', 'driver_id');
    }
}
