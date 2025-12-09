<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_ca extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'employee_cas';
    protected $fillable = array(
		'employee_id',
		'reason',
		'amount',
		'balance',
    );
    public $timestamps = true;

}
