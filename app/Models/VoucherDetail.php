<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherDetail extends Model
{
    protected $fillable = ['voucher_id', 'debit_account_id', 'credit_account_id', 'amount_money', 'content', 'bank_account_id'];
}
