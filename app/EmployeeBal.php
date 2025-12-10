<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeBal extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'employee_bal';
	protected $fillable = array(
		'logs_id',
		'balance',
		'employee_id',
	);
	public $timestamps = true;

}
