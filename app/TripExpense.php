<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TripExpense extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'trip_expense';
    protected $fillable = array(
		'trip_id',
		'description',
		'type',
        'amount',
        'status',
    );
    public $timestamps = true;

    public function tripId() {
        return $this->hasOne('App\trips', 'id', 'trip_id');
    }
}
