<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;

class Commodity extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'commodity';
    protected $fillable = array(
        'name',
        'price',
        'suki_price'
    );
    protected $dates = ['deleted_at'];
    protected $createRules = [
        'name' => 'required|unique:commodity',
        'price' => 'required|numeric',
        'suki_price' => 'required|numeric'
    ];
    protected $updateRules = [
        'name' => 'required',
        'price' => 'required|numeric',
        'suki_price' => 'required|numeric',
        'id' => 'required|exists:commodity'
    ];
    public $timestamps = true;

    public function validation($option, Array $request) {
        $request = preg_replace('!\s+!', ' ', $request);
        
        if($option === 'create') {
            $validation = Validator::make($request, $this->createRules, ['name.unique' => 'The commodity name has already been added.']);

            $validation->validate();
        } else if($option === 'update') {
            $validation = Validator::make($request, $this->updateRules);

            $validation->after(function ($validation) use ($request) {
                $isCommodityExists = $this->where('name', $request['name'])->where('id', '!=', $request['id'])->get()->count();

                if($isCommodityExists) {
                    $validation->errors()->add('commodity_name', 'The commodity name has already been added.');
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
