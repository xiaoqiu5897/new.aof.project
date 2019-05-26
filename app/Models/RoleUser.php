<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
// use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends Model
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
    protected $fillable = [
        'user_id', 'role_id',
    ];


    protected $table="role_users";
    
    public static function getRolesUser($id_request){
    	$data= DB::table('role_users')->select('role_id')->where('user_id',$id_request)->get();
    	return $data;
    }
    public static function getIDRolesUser($id_request){
        $data= DB::table('role_users')->select('user_id')->where('user_id',$id_request)->get();
        return $data;
    }
}
