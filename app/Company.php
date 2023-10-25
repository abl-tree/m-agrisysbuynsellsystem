<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Company extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'company';
    protected $fillable = array(
        'name'
    );
    protected $createRules = [
        'name' => 'required|unique:company'
    ];
    protected $updateRules = [
        'name' => 'required',
        'id' => 'required|exists:company',
    ];
    public $timestamps = true;

    public function validation($option, Array $request) {
        $request = preg_replace('!\s+!', ' ', $request);
        
        if($option === 'create') {
            $validation = Validator::make($request, $this->createRules, ['name.unique' => 'Company name has already been added.']);

            $validation->validate();
        } else if($option === 'update') {
            $validation = Validator::make($request, $this->updateRules);

            $validation->after(function ($validation) use ($request) {
                $isCompanyNotUnique = $this->where(['name' => $request['name']])->where('id', '!=', $request['id'])->get()->count();

                if($isCompanyNotUnique) {
                    $validation->errors()->add('name', 'Company name has already been added.');
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
}
