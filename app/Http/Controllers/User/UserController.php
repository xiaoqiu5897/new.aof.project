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
use App\Models\TheoryGroup;
use App\Models\ExerciseGroup;
use App\Models\UserCourseware;
use App\Models\Exercise;
use App\Models\JobCalendar;
use Datatables;
use Entrust;
use Illuminate\Support\Facades\Crypt;


class UserController extends Controller
{

    public function __construct() {
        $this->middleware('auth');

        // $this->middleware('permission:users-view')->only(['index', 'getListUser','getAllUserSelectOption']);
        // $this->middleware('permission:users-add')->only(['create', 'store']);
        // $this->middleware('permission:users-detail')->only(['show']);
        // $this->middleware('permission:users-roles')->only(['getRoles', 'postRoles']);
        // $this->middleware('permission:users-edit')->only(['update', 'edit', 'updateInfoUser']);
        // $this->middleware('permission:users-delete')->only(['destroy']);
        // $this->middleware('permission:users-courseware')->only(['getCourseware', 'postToggleTheories']);
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

            // $check_mail = User::where('email', $data['email'])->first();

            // if ($check_mail) {
            //     return response()->json([
            //         'error' => true,
            //         'message' => 'Địa chỉ email đã tồn tại!'
            //     ], 200);
            // }

            try {

                if (empty($data['birthday'])) {
                    $data['birthday'] = null;
                }

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
    public function edit($id)
    {
        //get type users
        $types = OptionValue::where('option_id', 1)->get();

        return view('users.edit', [
            'types' => $types,
        ]);
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
            JobCalendar::where('user_id', $id)->delete();
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

            // $permission_role = new PermissionRole;
            // $permission_role->permission_id = $data['permission_id'];
            // $permission_role->role_id = $data['role_id'];
            // $permission_role->save();
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
            //if (Entrust::can(["users-detail"])) {
                return '<a onclick="viewUser(' . $users->id . ')" data-toggle="modal" href="#viewUser">'.$users->name.'
                </a> ';
            //}else{
                //return $users->name;
            //}
        })
        
        ->addColumn('created_at', function($user){
            $time = $user->created_at;
            $time_numb = strtotime($time);

            return date("H:i | d-m-Y", $time_numb);
        })
        
       ->addColumn('action', function ($user) {

            $string = '';
            //if (Entrust::can(["users-roles"])) {
                $string = $string . ' <a href="users/'. $user->id . '/roles" class="btn green btn-xs" style="text-transform:none;" data-tooltip="tooltip" title="Vai trò">
                <i class="icon-lock ion" aria-hidden="true"></i> 
                </a> ';

                $string = $string . ' <a onclick="editUser(' . $user->id . ')" class="btn yellow btn-xs btn-withdrawal" style="text-transform:none;" data-toggle="modal" href="#editUser" data-tooltip="tooltip" title="Cập nhật">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
                </a> ';

                $string = $string . ' <a href="javascript:;" data-id="'. $user->id .'" type="button" class="btn btn-xs red btn-delete" style="text-transform:none;" data-tooltip="tooltip" title="Xóa">
                <i class="fa fa-trash-o"></i> 
                </a> ';
            //}

            return $string;
        })
       ->addIndexColumn()
       ->rawColumns(['action', 'name'])
       ->make(true);
    }

    /**
     * trang quan ly quyen học lieu
     *
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getCourseware($id) {

        $user = User::find($id);

        //ly thuyet

        $theory_groups = TheoryGroup::orderBy('created_at', 'desc')->get();

        if (!empty($theory_groups)) {
            foreach($theory_groups as $theory_group) {
                $theory_group->checked = 0;
                $flag = UserCourseware::where('user_id', $id)->where('theory_group_id', $theory_group->id)->where('type', 1)->first();
                if(!empty($flag)) {
                    $theory_group->checked = 1;
                }
            }
        }
        //bat tap
        $exercise_groups = ExerciseGroup::orderBy('created_at', 'desc')->get();
        if (!empty($exercise_groups)) {
            foreach($exercise_groups as $exercise_group) {
                $exercise_group->checked = 0;
                $flag1 = UserCourseware::where('user_id', $id)->where('exercise_group_id', $exercise_group->id)->where('type', 2)->first();
                if(!empty($flag1)) {
                    $exercise_group->checked = 1;
                }
            }
        } 
        return view('users.manage-coursewares',[
            'user' => $user,
            'theory_groups' => $theory_groups,
            'exercise_groups' => $exercise_groups
        ]);

    } 
    public function listCourseware($id)
    {
        $theory_groups = TheoryGroup::orderBy('created_at', 'desc')->get();

        if (!empty($theory_groups)) {
            foreach($theory_groups as $theory_group) {
                $theory_group->checked = 0;
                $flag = UserCourseware::where('user_id', $id)->where('theory_group_id', $theory_group->id)->where('type', 1)->first();
                if(!empty($flag)) {
                    $theory_group->checked = 1;
                }
            }
        }
        return Datatables::of($theory_groups)
        ->addIndexColumn()
        ->addColumn('action', function ($theory_groups) {
 
            $string = '<input type="hidden" id="checked-'.$theory_groups->id.'" value="'.$theory_groups->checked.'">';
            if(!empty($theory_groups->checked)){
            $string .= '<i id="action-'.$theory_groups->id.'" class="fa fa-check-circle" onclick="addTheoryGroup('.$theory_groups->id.')" aria-hidden="true" style="cursor: pointer; color: #3598dc;font-size: 20px;"></i>';
            }else{
            $string .= '<i id="action-'.$theory_groups->id.'" class="fa fa-circle-o"  onclick="addTheoryGroup('.$theory_groups->id.')" aria-hidden="true" style="cursor: pointer; color: #3598dc;font-size: 20px;"></i>';
            }
            
            return $string;
        })
        ->editColumn('theories', function($theory_groups) {
           
            $string = '<p style="text-align: center;">'.$theory_groups->theories->count().'</p>';
                return $string;
        })
        // ->rawColumns(['theories', 'action'])
        ->make(true);
    }

    public function listexercise($id)
    {
        $exercise_groups = ExerciseGroup::orderBy('created_at', 'desc')->get();
        if (!empty($exercise_groups)) {
            foreach($exercise_groups as $exercise_group) {
                $exercise_group->checked = 0;
                $flag1 = UserCourseware::where('user_id', $id)->where('exercise_group_id', $exercise_group->id)->where('type', 2)->first();
                if(!empty($flag1)) {
                    $exercise_group->checked = 1;
                }
            }
        }

        return Datatables::of($exercise_groups)
        ->addIndexColumn()
        ->addColumn('action', function ($exercise_groups) {
 
            $string = '<input type="hidden" id="checked-ex-'.$exercise_groups->id.'" value="'.$exercise_groups->checked.'">';
            if(!empty($exercise_groups->checked)){
            $string .= '<i id="action-ex-'.$exercise_groups->id.'" class="fa fa-check-circle" onclick="addExerciseGroup('.$exercise_groups->id.')" aria-hidden="true" style="cursor: pointer; color: #3598dc;font-size: 20px;"></i>';
            }else{
            $string .= '<i id="action-ex-'.$exercise_groups->id.'" class="fa fa-circle-o"  onclick="addExerciseGroup('.$exercise_groups->id.')" aria-hidden="true" style="cursor: pointer; color: #3598dc;font-size: 20px;"></i>';
            }      
            return $string;
        })
        ->editColumn('exercises', function($exercise_groups) {    
            $string = '<p style="text-align: center;">'.$exercise_groups->exercises->count().'</p>';
                return $string;
        })
        ->make(true);


    }
 
                                 
    /**
     * toggle theories group
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function postToggleTheories(Request $request) {

        $data = $request->all();

        if ($data['checked']) {

            UserCourseware::where('user_id', $data['user_id'])->where('theory_group_id', $data['theory_group_id'])->where('type', 1)->delete();


            return response()->json([
                'error' => false,
                'message' => 'deleted'
            ], 200);


        } else {

            $data['type'] = 1; // ly thuyet

            UserCourseware::create($data);

            return response()->json([
                'error' => false,
                'message' => 'added'
            ], 200);
        }
    }


    /**
     * toggle exercise group
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function postToggleExercises(Request $request) {
        $data = $request->all();

        if ($data['checked']) {

            UserCourseware::where('user_id', $data['user_id'])->where('exercise_group_id', $data['exercise_group_id'])->where('type', 2)->delete();

            return response()->json([
                'error' => false,
                'message' => 'deleted'
            ], 200);


        } else {

            $data['type'] = 2; // bai tap

            UserCourseware::create($data);

            return response()->json([
                'error' => false,
                'message' => 'added'
            ], 200);
        }
    }

    public function getInfoUser(Request $request){
        // return User::select('id as MNV' ,'name as Họ và tên', 'gender as Giới tính', 'birthday as Ngày sinh', 'mobile as SĐT', 'email as Email', 'address as Địa chỉ', 'work_place as Nơi làm việc ', 'skill as Kỹ năng', 'type As Vị trí', 'status as Trạng thái')->find($request->id);
        //
        return User::find($request->id);
    }

    public function updateInfoUser(Request $request){

        $data = $request->all();

        $user = User::find($request->id);

        $user_mobile = "";

        if ($request->mobile != $user['mobile']) {
            //sdt khac so ban dau
            $check = User::where('mobile', $request->mobile )->count();

            if ($check > 0) { // check trung sdt

                return response()->json([
                    'error' =>  true,
                    'status'    =>  'error',
                    'message'   =>  'Số điện thoại đã tồn tại trong hệ thống !'
                ]);

            }else{
                // sdt khong bi trung

                $user_mobile = $request->mobile;
            }
        }else{
            //sdt khong thay doi

            $user_mobile = $user['mobile'];
        }

        try{

            if (empty($request->birthday)) {
                $request->birthday = "1996-06-11";
            }

            if (empty($data['avatar'])) {
                $data['avatar'] = "/images/zents/no-image.png";
            }

            $user = User::find($request->id);

            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->gender = $request->gender;
            $user->birthday = $request->birthday;
            $user->describe = $request->describe;
            $user->status = $request->status;
            $user->type = $request->type;
            $user->department_id = $request->department_id;
            $user->type_job = $request->type_job;
            $user->avatar = $request->avatar;

            $user->save();

            if ($user->type_job=="") {
                JobCalendar::where('user_id', $user->id)->whereIn('type', [0,1])->delete();
            }else if($data['type_job']==0){
                $checkJob = JobCalendar::where('user_id', $user->id)->where('type', 0)->first();
                if(empty($checkJob)){
                    JobCalendar::create([
                        'user_id' => $user->id,
                        'type' => 0,
                    ]);
                }

                //delete job calendar of user
                JobCalendar::where('user_id', $user->id)->where('type', 1)->delete();
            }else{
                JobCalendar::where('user_id', $user->id)->where('type', 0)->delete();
            }

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

    public function unlockUser(Request $request){
        $data = User::find($request->id)->update(['status' => 1]);

        return response()->json([
            'status' => true,
        ]);
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
