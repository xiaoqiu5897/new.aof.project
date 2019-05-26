<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RoleUser;
use App\Models\PermissionRole;
use Datatables;
use Entrust;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:roles-manager')->only(['index','update','store','destroy','getListPermission','getPermissions','getListRole','postPermissions','show']);
        $this->middleware('permission:roles-detail')->only('edit');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('created_at', 'desc')->get();
        return view('roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [  
            'display_name' => 'required',
            // 'name' => 'required|unique:roles',
            'name' => 'required',
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập vai trò',
            // 'name.unique' => 'Vai trò đã tồn tại, vui lòng nhập vai trò khác',
            'display_name.required' => 'Vui lòng nhập tên hiển thị',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else {
            \DB::beginTransaction();

            try {
                $role = Role::where('name', $data['name'])->count();
                if ($role>0) {
                    return response()->json([
                            'error' => true,
                            'message' => 'Vai trò này đã có. Mời bạn thử lại!'
                        ]);
                 } else {
                    $check= Role::where('name', $data['name'])->first();
                    if(empty($check)){
                        Role::create($data);
                    }else{
                        $check->restore();

                        unset($data['_token']);
                        unset($data['_method']);

                        Role::where('name', $data['name'])->update($data);
                    }

                    // Commit db
                    \DB::commit();

                    return response()->json([
                            'error' => false,
                            'data' => 'success'
                        ]);
                 }
               
            } catch (\Exception $e) {

                \DB::rollback();

                \Log::info($e->getMessage());

                return response()->json([
                        'error' => true,
                        'message' => $e->getMessage()
                    ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'error' => false,
            'data' => Role::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $rules = [  
            'display_name' => 'required',
            'name' => 'required|unique:roles,name,' .$id,
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập vai trò',
            'name.unique' => 'Vai trò đã tồn tại, vui lòng nhập vai trò khác',
            'display_name.required' => 'Vui lòng nhập tên hiển thị',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        } else {
            \DB::beginTransaction();

            try {

                $role = Role::where('name', $data['name'])->count();
                if ($role>1) {
                    return response()->json([
                            'error' => true,
                            'message' => 'Vai trò này đã có. Mời bạn thử lại!'
                        ]);
                 } else {

                    unset($data['_token']);
                    unset($data['_method']);
                    unset($data['q']);

                    Role::where('id', $id)->update($data);

                    // Commit db
                    \DB::commit();

                    return response()->json([
                            'error' => false,
                            'data' => 'success'
                        ]);
                }
            } catch (\Exception $e) {

                \DB::rollback();

                \Log::info($e->getMessage());

                return response()->json([
                        'error' => false,
                        'message' => $e->getMessage()
                    ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            if (empty(RoleUser::where('role_id', $id)->first())) {
                PermissionRole::where('role_id', $id)->delete();
                // RoleUser::where('role_id', $id)->delete();
                Role::where('id', $id)->delete();
                DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => 'Delete success!'
                ], 200);
            }else{
                DB::commit();
                return response()->json([
                    'error' => true,
                    'message' => 'Delete errors!'
                ], 200);
            }
        } catch(Exception $e) {
            Log::info('Can not delete role has id = ' . $id);
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * get list permissions
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function getPermissions($name) {
        $role = Role::where('name', $name)->first();
        $permissions = Permission::all();

        if(!empty($permissions)) {
            foreach ($permissions as $key => &$permission) {
                $permission->checked = 0;
                $flag = PermissionRole::where('role_id', $role->id)->where('permission_id', $permission->id)->first();
                if(!empty($flag)) {
                    $permission->checked = 1;
                }
            }
        }


        return view('roles.permissions',[
            'role' => $role,
            'permissions' => $permissions,
            'name' => $name
        ]);
    }

    /**
     * add or delete permission
     * @return [type] [description]
     */
    public function postPermissions(Request $request) {

        $data = $request->all();

        // dd($data);


        if ($data['checked']) {
            
            DB::delete('delete from permission_roles where permission_id = ? and role_id = ?', [$data['permission_id'], $data['role_id']]);

            return response()->json([
                'error' => false,
                'message' => 'deleted'
            ], 200);


        } else {

            PermissionRole::create($data);
           
            return response()->json([
                'error' => false,
                'message' => 'added'
            ], 200);
        }
    }


    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListRole()
    {   
        $roles = Role::orderBy('created_at', 'desc')->get();

        return Datatables::of($roles)
            ->addIndexColumn()
            ->editColumn('created_at', function($role){
                $time = $role->created_at;
                $time_numb = strtotime($time);

                return date("H:i | d-m-Y", $time_numb);
            })
            ->addColumn('action', function ($role) {

                $string = '';
                if (Entrust::can(["roles-manager"])) {
                    $string = $string .' <a href="roles/' . $role->name .'/permissions" class="btn btn-xs blue" data-tooltip="tooltip" title="Quyền hạn">
                            <i class="icon-shield ion" aria-hidden="true"></i> 
                        </a>';

                   $string = $string . '<a href="javascript:;" data-id="'. $role->id .'"  class="btn yellow btn-xs btn-edit" data-tooltip="tooltip" title="Chỉnh sửa">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>';
                
                    $string = $string . '<a href="javascript:;" type="button" data-id="'. $role->id .'" class="btn btn-xs red btn-delete" data-tooltip="tooltip" title="Xóa">
                            <i class="fa fa-trash-o"></i>
                          </a>';
                }
                return $string;
            })
            ->make(true);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListPermission($name)
    {   
        $role = Role::where('name', $name)->first();

        $permissions = Permission::orderBy('id', 'desc');

        return Datatables::of($permissions)
            ->addIndexColumn()
            ->addColumn('action', function ($permission) use ($role) {

            	$flag = PermissionRole::where('role_id', $role->id)->where('permission_id', $permission->id)->first();

                if (!empty($flag)) {

                	$string = '<input type="hidden" id="checked-' .$permission->id . '" value="1">';

                	$string = $string . '<i id="action-'. $permission->id. '" class="fa fa-check-circle" data-tooltip="tooltip"  title="Xóa" onclick="addPermission('. $role->id . ', ' .$permission->id . ')" aria-hidden="true" style="cursor: pointer; color: #3598dc;font-size: 20px;"></i>';
                } else {

                	$string = '<input type="hidden" id="checked-' .$permission->id . '" value="0">';

                	$string = $string .'<i id="action-'. $permission->id .'" class="fa fa-circle-o"  data-tooltip="tooltip" onclick="addPermission(' . $role->id . ',' . $permission->id . ')" title="Thêm" aria-hidden="true" style="cursor: pointer; color: #3598dc;font-size: 20px;"></i>';
                }
                return $string;
            })
            ->make(true);
    }
}
