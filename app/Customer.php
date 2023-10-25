<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'id';
    protected $table = 'customer';
    protected $fillable = array(
        'fname',
        'mname',
        'lname',
        'contacts',
        'address',
        'suki_type'
    );
    protected $createRules = [
        'fname' => 'required',
        'lname' => 'required',
        'contacts' => 'required',
        'address' => 'required',
    ];
    protected $updateRules = [
        'fname' => 'required',
        'lname' => 'required',
        'contacts' => 'required',
        'address' => 'required',
        'id' => 'required|exists:customer',
    ];
    public $timestamps = true;

    public function validation($option, Array $request) {
        $request = preg_replace('!\s+!', ' ', $request);

        if($option === 'create') {
            $validation = Validator::make($request, $this->createRules);

            $validation->after(function ($validation) use ($request) {
                $isCustomerExists = $this->where(['fname' => $request['fname'], 'mname' => $request['mname'], 'lname' => $request['lname']])->get()->count();

                if($isCustomerExists) {
                    $validation->errors()->add('customer', 'Customer already exists.');
                }
            });

            $validation->validate();
        } else if($option === 'update') {
            $validation = Validator::make($request, $this->updateRules);

            $validation->after(function ($validation) use ($request) {
                $isCustomerExists = $this->where(['fname' => $request['fname'], 'mname' => $request['mname'], 'lname' => $request['lname']])->where('id', '!=', $request['id'])->get()->count();

                if($isCustomerExists) {
                    $validation->errors()->add('customer', 'Customer already exists.');
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

    public function getAddressAttribute($value)
    {
        return ucwords($value);
    }
    
    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = preg_replace('!\s+!', ' ', ucwords($value));
    }
}
