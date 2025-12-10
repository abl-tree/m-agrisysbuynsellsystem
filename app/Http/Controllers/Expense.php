<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'expenses';
    protected $fillable = array(
        'description',
        'type',
        'amount'
    );

    public $timestamps = true;

}