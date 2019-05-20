<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['code', 'name', 'type', 'accounting_date', 'object_id', 'name_payer', 'addrress', 'reason', 'money_id', 'exchange_rate', 'account_to', 'account_from', 'status'];
}
