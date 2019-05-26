<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class FinanceAccount extends Authenticatable
{
	use Notifiable, EntrustUserTrait;

	protected $table = 'finance_accounts';
    protected $fillable = ['code', 'name' , 'type', 'level', 'parent_id', 'surplus_debit', 'surplus_credit'];
}
