<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class price extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'prices';
    protected $appends = [
        'commodity','company','datetime'
     ];
    protected $fillable = array(
        'commodity_id',
        'company_id',
        'price',
        'date',
    );

    public function commodities() {
        return $this->hasOne('\App\Commodity', 'id', 'commodity_id');
    }
    public function companies() {
        return $this->hasOne('\App\Company', 'id', 'company_id');
    }

    public function getCommodityAttribute(){
       
        return $this->commodities->name;
    }
    public function getCompanyAttribute(){
       
        return $this->companies->name;
    }
    public function getDatetimeAttribute(){
       
        return date('F d, Y g:i a', strtotime($this->created_at));
    }

}
