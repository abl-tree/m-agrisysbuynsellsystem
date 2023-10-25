<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dtr extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'dtr';
    protected $fillable = array(
        'role',
        'employee_id',
        'rate',
        'salary',
        'deductions',
    );
    public $timestamps = true;

    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

    public function getDeductionsObjectAttribute($value)
    {
        return json_decode($value);
    }

    public function setDeductionsObjectAttribute($value)
    {
        $this->attributes['deductions_object'] = json_encode($value);
    }
}
