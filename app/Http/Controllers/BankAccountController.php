<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\Bank;
use Datatables;
use Entrust;
use Validator;
use DB;

class BankAccountController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        // $this->middleware('permission:roles-manager')->only(['index','update','store','destroy','getListPermission','getPermissions','getListRole','postPermissions','show']);
        // $this->middleware('permission:roles-detail')->only('edit');
    }

    public function getListBankAccount() {
    	$bank_accounts = BankAccount::orderBy('created_at', 'desc');

        return Datatables::of($bank_accounts)
            ->addIndexColumn()
            ->editColumn('created_at', function($bank_accounts){
                $time = $bank_accounts->created_at;
                $time_numb = strtotime($time);

                return date("H:i | d-m-Y", $time_numb);
            })
            ->editColumn('bank_id', function($bank_accounts){
                $bank_name = BankAccount::find($bank_accounts->id)->bank->name;
                return $bank_name;
            })
            ->addColumn('action', function ($bank_accounts) {

                $string = '';

                if (Entrust::can(["roles-manager"])) {

                   	$string = $string . '<a href="javascript:;" data-id="'. $bank_accounts->id .'"  class="btn yellow btn-xs btn-edit" data-tooltip="tooltip" title="Chỉnh sửa">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>';
                
                    $string = $string . '<a href="javascript:;" type="button" data-id="'. $bank_accounts->id .'" class="btn btn-xs red btn-delete" data-tooltip="tooltip" title="Xóa">
                            <i class="fa fa-trash-o"></i>
                          </a>';
                }
                return $string;
            })
            ->make(true);
    }

    public function index() {
        $banks = Bank::all();

    	return view('bank-accounts.index', compact('banks'));
    }

    public function store(Request $request) {
    	$data = $request->all();

        $rules = [
            'name' => 'required',
            'bank_account' => 'required',
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập tên',
            'bank_account.required' => 'Vui lòng nhập tài khoản ngân hàng',
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

                $bank_account = BankAccount::create($data);
               
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
    	$bank_account = BankAccount::where('id', $id)->first();
		//dd($employee);
		return response()->json([
                    'error' => false,
                    'data' => $bank_account
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
                $bank_account = BankAccount::where('id', $id)->update($data);
               
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
    	BankAccount::where('id', $id)->delete();

    	return response()->json([
                    'error' => false,
                    'message' => 'Ok'
                ]);
    }
}
