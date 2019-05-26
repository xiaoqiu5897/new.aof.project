<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Employee extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'group_objects';

    protected $fillable = [
        'name', 'email', 'password', 'code', 'type', 'address', 'mobile', 'tax_code', 'bank_account', 'bank_id'
    ];

    public function bank() {
        return $this->belongsTo('App\Models\Bank');
    }
}
