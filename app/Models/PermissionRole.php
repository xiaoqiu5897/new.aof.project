<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class PermissionRole extends Model
{
	// use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="permission_roles";

    // protected $primaryKey = ['permission_id', 'role_id'];

    protected $fillable = [
        'permission_id', 'role_id',
    ];
}
