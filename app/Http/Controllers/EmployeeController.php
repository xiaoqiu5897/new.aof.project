<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\GroupObject;
use App\Models\Bank;
use Datatables;
use Entrust;
use Validator;
use DB;

class EmployeeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        // $this->middleware('permission:roles-manager')->only(['index','update','store','destroy','getListPermission','getPermissions','getListRole','postPermissions','show']);
        // $this->middleware('permission:roles-detail')->only('edit');
    }

    public function index() {
    	//lấy type từ get method
    	$type = Input::get('type', false);
    	//dd($type);
    	$banks = Bank::all();

    	return view('employees.index', compact('banks','type'));
	}

	public function getListEmployee() {
		//lấy type từ get method
		$type = Input::get('type', false);

		$employees = GroupObject::where('type', $type)->orderBy('created_at', 'desc')->get();

        return Datatables::of($employees)
            ->addIndexColumn()
            ->editColumn('created_at', function($employees){
                $time = $employees->created_at;
                $time_numb = strtotime($time);

                return date("H:i | d-m-Y", $time_numb);
            })
            ->addColumn('action', function ($employees) {

                $string = '';

                if (Entrust::can(["roles-manager"])) {

                   	$string = $string . '<a href="javascript:;" data-id="'. $employees->id .'"  class="btn yellow btn-xs btn-edit" data-tooltip="tooltip" title="Chỉnh sửa">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>';
                
                    $string = $string . '<a href="javascript:;" type="button" data-id="'. $employees->id .'" class="btn btn-xs red btn-delete" data-tooltip="tooltip" title="Xóa">
                            <i class="fa fa-trash-o"></i>
                          </a>';
                }
                return $string;
            })
            ->make(true);
	}

	public function store(Request $request) {
    	$data = $request->all();
		//lấy type từ get method
    	$type = Input::get('type', false);
        //dd($data);
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'code' => 'required|unique:group_objects',
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'code.unique' => 'Code đã tồn tại',
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

            	$data['type'] = $type;

                $employee = GroupObject::create($data);
               
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

	public function show($id) {
		$employee = GroupObject::where('id', $id)->first();
		//dd($employee);
		return response()->json([
                    'error' => false,
                    'data' => $employee
                ]);
	}

	public function update(Request $request, $id) {
    	$data = $request->all();
        //dd($data);
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'code' => 'required',
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'code.unique' => 'Vui lòng nhập mã',
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
            	$check_code = GroupObject::where('code', $data['code'])->first();

            	if (isset($check_code)) {
            		if ($check_code['id'] != $id) {
            			return response()->json([
			                'error' => true,
			                'message' => 'Mã nhân viên đã tồn tại'
			            ], 200);
            		}
            	}

                $employee = GroupObject::where('id', $id)->update($data);
               
                \DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => "Cập nhật thông tin thành công "
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

	public function destroy($id) {
    	GroupObject::where('id', $id)->delete();

    	return response()->json([
                    'error' => false,
                    'message' => 'Ok'
                ]);
	}
}
