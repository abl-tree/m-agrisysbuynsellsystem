<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Trucks extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'trucks';
    protected $fillable = array(
        'name',
        'plate_no'
    );
    protected $createRules = [
        'name' => 'required|unique:trucks',
        'plate_no' => 'required|unique:trucks'
    ];
    protected $updateRules = [
        'name' => 'required',
        'plate_no' => 'required',
        'id' => 'required|exists:trucks'
    ];
    public $timestamps = true;

    public function validation($option, Array $request) {
        $request = preg_replace('!\s+!', ' ', $request);

        if($option === 'create') {
            $validation = Validator::make($request, $this->createRules,['plate_no.unique' => 'The plate number has already been added.']);

            $validation->validate();
        } else if($option === 'update') {
            $validation = Validator::make($request, $this->updateRules);

            $validation->after(function ($validation) use ($request) {
                $isTruckNameExists = $this->where('name', $request['name'])->where('id', '!=', $request['id'])->get()->count();
                $isPlateNoExists = $this->where('plate_no', $request['plate_no'])->where('id', '!=', $request['id'])->get()->count();

                if($isTruckNameExists) {
                    $validation->errors()->add('trucks_name', 'The name has already been added.');
                }
                
                if($isPlateNoExists) {
                    $validation->errors()->add('trucks_plate_no', 'The plate number has already been added.');
                }
            });

            $validation->validate();
            return $this->find($request['id']);
        }
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
    
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = preg_replace('!\s+!', ' ', ucwords($value));
    }

    public function getPlateNoAttribute($value)
    {
        return ucwords($value);
    }
    
    public function setPlateNoAttribute($value)
    {
        $this->attributes['plate_no'] = preg_replace('!\s+!', ' ', strtoupper($value));
    }
}
