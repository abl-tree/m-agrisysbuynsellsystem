<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DtrExpense extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'dtr_expense';
    protected $fillable = array(
		'dtr_id',
		'description',
		'type',
        'amount',
        'status',
    );
    public $timestamps = true;

    public function dtrId() {
        return $this->hasOne('App\dtr', 'id', 'dtr_id');
    }
}
