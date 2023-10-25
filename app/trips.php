<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trips extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'trips';
    protected $fillable = array(
		'ticket_number',
		'expense',
		'commodity_id',
		'truck_id',
		'driver_id',
		'destination',
		'num_liters',
    'laborers',
    'remarks'
    );
    public $timestamps = true;

    public function employee() {
        return $this->hasOne('App\Employee', 'id', 'driver_id');
    }
}
