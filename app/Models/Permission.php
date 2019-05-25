<?php

namespace App\Models;

use Zizaco\Entrust\EntrustPermission;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends EntrustPermission
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="permissions";

    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    /**
     * get roles
     * @return objects 
     */

	public function roles() {
		return $this->belongsToMany('App\Models\Role', 'permission_roles', 'permission_id', 'role_id');
	}
}
