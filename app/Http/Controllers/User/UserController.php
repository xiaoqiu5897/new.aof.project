<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use Log;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Datatables;
use Entrust;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:users-manager')->only(['create','store','destroy','getRoles','postRoles','updateInfoUser','getListUser']);
        $this->middleware('permission:users-detail')->only('getInfoUser');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at','DESC')->paginate(env('PAGES'));

        $flag = User::count() > env('PAGES') ? true : false;

        return view('users.list-user',[
            'users' => $users,
            'flag' => $flag,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        //get type users
        

        return view('users.create', [
            'types' => $types,
            'departments' => $departments,
        ]);
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
        //dd($data);
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users',
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email đã tồn tại, vui lòng chọn email khác',
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

                $data['password'] =bcrypt('123456');

                $user = User::create($data);
               
                \DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => "Thêm mới tài khoản thành công "
                ]);

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        
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
        //
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

            RoleUser::where('user_id', $id)->delete();

            User::where('id', $id)->delete();

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => 'Delete success!'
            ], 200);

        } catch(Exception $e) {
            Log::info('Can not delete user has id = ' . $id);
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * get list role for user
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getRoles($id) {
        $user = User::find($id);
        $roles = Role::orderBy('created_at', 'desc')->get();

        if (!empty($roles)) {
            foreach ($roles as $key => &$role) {

                $role->checked = 0;
                $flag = RoleUser::where('user_id', $id)->where('role_id', $role->id)->first();

                if(!empty($flag)) {
                    $role->checked = 1;
                }

            }
        }
        return view('users.roles', [
            'roles' => $roles,
            'user' => $user
        ]);
    }

    /**
     * add or delete role
     * @return [type] [description]
     */
    public function postRoles(Request $request) {

        $data = $request->all();

        if ($data['checked']) {

            DB::delete('delete from role_users where user_id = ? and role_id = ?', [$data['user_id'], $data['role_id']]);

            return response()->json([
                'error' => false,
                'message' => 'deleted'
            ], 200);

        } else {

            RoleUser::create($data);

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
    public function getListUser()
    {
        $users = User::query()->orderBy('created_at', 'desc');

        return Datatables::of($users)
        ->editColumn('name', function($users){
            if (Entrust::can(["users-detail"])) {
                return '<a onclick="viewUser(' . $users->id . ')" data-toggle="modal" href="#viewUser">'.$users->name.'
                </a> ';
            }else{
                return $users->name;
            }
        })
        
        ->addColumn('created_at', function($user){
            $time = $user->created_at;
            $time_numb = strtotime($time);

            return date("H:i | d-m-Y", $time_numb);
        })
        
       ->addColumn('action', function ($user) {

            $string = '';
            if (Entrust::can(["users-manager"])) {
                $string = $string . ' <a href="users/'. $user->id . '/roles" class="btn green btn-xs" style="text-transform:none;" data-tooltip="tooltip" title="Vai trò">
                <i class="icon-lock ion" aria-hidden="true"></i> 
                </a> ';

                $string = $string . ' <a onclick="editUser(' . $user->id . ')" class="btn yellow btn-xs btn-withdrawal" style="text-transform:none;" data-toggle="modal" href="#editUser" data-tooltip="tooltip" title="Cập nhật">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
                </a> ';

                $string = $string . ' <a href="javascript:;" data-id="'. $user->id .'" type="button" class="btn btn-xs red btn-delete" style="text-transform:none;" data-tooltip="tooltip" title="Xóa">
                <i class="fa fa-trash-o"></i> 
                </a> ';
            }

            return $string;
        })
       ->addIndexColumn()
       ->rawColumns(['action', 'name'])
       ->make(true);
    }

    public function getInfoUser(Request $request){
        // return User::select('id as MNV' ,'name as Họ và tên', 'gender as Giới tính', 'birthday as Ngày sinh', 'mobile as SĐT', 'email as Email', 'address as Địa chỉ', 'work_place as Nơi làm việc ', 'skill as Kỹ năng', 'type As Vị trí', 'status as Trạng thái')->find($request->id);
        //
        return User::find($request->id);
    }

    public function updateInfoUser(Request $request){

        $data = $request->all();
        //dd($data);
        try{
            $check_email = User::where('email', $data['email'])->first();

            if ($check_email['id'] != $data['id']) {
                return response()->json([
                    'error' =>  true,
                    'status'    =>  'error',
                    'message'   =>  'Email đã tồn tại!'
                ]);
            }

            $user = User::find($request->id);

            $user->name = $request->name;

            $user->save();

            return response()->json([
                'error' =>  false,
                'status'    =>  'success',
                'message'   =>  'Update thành công !'
            ]);
            // return $user;
        } catch(Exception $e){

            return response()->json([
                'error' =>  true,
                'status'    =>  'error',
                'message'   =>  'Internal Server Error'
            ]);
        }
    }

    public function getAllUserSelectOption()
    {
        $result = '<option value="">Vui lòng chọn</option>';
        $users = User::where('status','!=',0)->orderBy('name')->pluck('name','id')->toArray();
        if (!empty($users)){
            foreach ($users as $id => $name){
                $result .= '<option value="'. $id .'">'. $name .'</option>';
            }
        }
        return $result;
    }
}
