<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class Employee extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'employee';
    protected $fillable = array(
        'fname',
        'mname',
        'lname',
        'role_id'
    );
    protected $createRules = [
        'fname' => 'required',
        'lname' => 'required',
        'role_id' => 'required|exists:roles,id'
    ];
    protected $updateRules = [
        'fname' => 'required',
        'lname' => 'required',
        'role_id' => 'required|exists:roles,id',
        'id' => 'required|exists:employee',
    ];
    public $timestamps = true;

    public function validation($option, Array $request) {
        $request = preg_replace('!\s+!', ' ', $request);

        if($option === 'create') {
            $validation = Validator::make($request, $this->createRules);

            $validation->after(function ($validation) use ($request) {
                $isEmployeeExists = $this->where(['fname' => $request['fname'], 'mname' => $request['mname'], 'lname' => $request['lname']])->get()->count();

                if($isEmployeeExists) {
                    $validation->errors()->add('employee', 'Employee already exists.');
                }
            });

            $validation->validate();
        } else if($option === 'update') {
            $validation = Validator::make($request, $this->updateRules);

            $validation->after(function ($validation) use ($request) {
                $isEmployeeExists = $this->where(['fname' => $request['fname'], 'mname' => $request['mname'], 'lname' => $request['lname']])->where('id', '!=', $request['id'])->get()->count();

                if($isEmployeeExists) {
                    $validation->errors()->add('employee', 'Employee already exists.');
                }
            });

            $validation->validate();
            return $this->find($request['id']);
        }
    }

    public function getFnameAttribute($value)
    {
        return ucwords($value);
    }
    
    public function setFnameAttribute($value)
    {
        $this->attributes['fname'] = preg_replace('!\s+!', ' ', ucwords($value));
    }

    public function getMnameAttribute($value)
    {
        return ucwords($value);
    }
    
    public function setMnameAttribute($value)
    {
        $this->attributes['mname'] = preg_replace('!\s+!', ' ', ucwords($value));
    }

    public function getLnameAttribute($value)
    {
        return ucwords($value);
    }
    
    public function setLnameAttribute($value)
    {
        $this->attributes['lname'] = preg_replace('!\s+!', ' ', ucwords($value));
    }

    public function cashier(){
        return $this->hasOne('App\Roles', 'id', 'role_id');
    }

    public function role_id(){
        return $this->hasOne('App\Roles', 'id', 'role_id');
    }
}
