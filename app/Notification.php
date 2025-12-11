<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notification_type', 'message', 'status', 'admin_id', 'cashier_id', 'table_source', 'cash_advance_id', 'dtr_expense_id', 'trip_expense_id', 'expense_id', 'od_expense_id'
    ];

    /**
     * Get the notification's status.
     *
     * @param  string  $value
     * @return string
     */
    public function getStatusAttribute($value)
    {
        return strtolower($value);
    }

    /**
     * Get the notification's status.
     *
     * @param  string  $value
     * @return string
     */
    public function getNotificationTypeAttribute($value)
    {
        return strtolower($value);
    }

    public function cash_advance() {
        return $this->hasOne('App\Ca', 'id', 'cash_advance_id');
    }

    public function expense() {
        return $this->hasOne('App\Expense', 'id', 'expense_id');
    }

    public function dtr() {
        return $this->hasOne('App\DtrExpense', 'id', 'dtr_expense_id');
    }

    public function trip() {
        return $this->hasOne('App\TripExpense', 'id', 'trip_expense_id');
    }

    public function od() {
        return $this->hasOne('App\od_expense', 'id', 'od_expense_id');
    }

    public function admin() {
        return $this->hasOne('App\User', 'id', 'admin_id');
    }

    public function cashier() {
        return $this->hasOne('App\User', 'id', 'cashier_id');
    }
}
