<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Money;
use Datatables;
use Entrust;
use Validator;
use DB;

class MoneyController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        // $this->middleware('permission:roles-manager')->only(['index','update','store','destroy','getListPermission','getPermissions','getListRole','postPermissions','show']);
        // $this->middleware('permission:roles-detail')->only('edit');
    }

    public function getListMoney() {
    	$moneys = Money::orderBy('created_at', 'desc');

        return Datatables::of($moneys)
            ->addIndexColumn()
            ->editColumn('created_at', function($moneys){
                $time = $moneys->created_at;
                $time_numb = strtotime($time);

                return date("H:i | d-m-Y", $time_numb);
            })
            ->addColumn('action', function ($moneys) {

                $string = '';

                if (Entrust::can(["roles-manager"])) {

                   	$string = $string . '<a href="javascript:;" data-id="'. $moneys->id .'"  class="btn yellow btn-xs btn-edit" data-tooltip="tooltip" title="Chỉnh sửa">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>';
                
                    $string = $string . '<a href="javascript:;" type="button" data-id="'. $moneys->id .'" class="btn btn-xs red btn-delete" data-tooltip="tooltip" title="Xóa">
                            <i class="fa fa-trash-o"></i>
                          </a>';
                }
                return $string;
            })
            ->make(true);
    }

    public function index() {
    	return view('moneys.index');
    }

    public function store(Request $request) {
    	$data = $request->all();
		
        $rules = [
            'name' => 'required',
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập tên',
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

                $money = Money::create($data);
               
                \DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => "Thêm mới thành công "
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
    	$money = Money::where('id', $id)->first();
		//dd($employee);
		return response()->json([
                    'error' => false,
                    'data' => $money
                ]);
    }

    public function update(Request $request, $id) {
    	$data = $request->all();
        //dd($data);
        $rules = [
            'name' => 'required',
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập tên',
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
                $money = Money::where('id', $id)->update($data);
               
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
    	Money::where('id', $id)->delete();

    	return response()->json([
                    'error' => false,
                    'message' => 'Ok'
                ]);
    }
}
