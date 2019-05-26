<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Bank extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name'
    ];

    public function employees() {
        return $this->hasMany('App\Models\Employee','bank_id');
    }

    public function bankAccounts() {
        return $this->hasMany('App\Models\BankAccount','bank_id');
    }
}
