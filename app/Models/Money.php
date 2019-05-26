<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Money extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

    protected $table = 'moneys';
    protected $fillable = [
        'name'
    ];
}