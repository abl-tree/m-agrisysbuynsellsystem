<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sales extends Model
{
	protected $primaryKey = 'id';
     protected $table = 'sales';
     protected $fillable = array(
         'commodity_id',
         'receiver_id',
         'company_id',
        'kilos',
        'check_number',
	    'amount'
     );

}
