<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ca extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'cash_advance';
    protected $fillable = array(
		'customer_id',
		'reason',
		'amount',
		'balance',
    );
    public $timestamps = true;

    public function customer() {
        return $this->hasOne('App\Customer', 'id', 'customer_id');
    }
}
