<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class od_expense extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'od_expense';
    protected $fillable = array(
		'od_id',
		'description',
		'type',
        'amount',
        'status',
    );
    public $timestamps = true;

    public function odId() {
        return $this->hasOne('App\od', 'id', 'od_id');
    }
}