<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinanceAccount;
use Datatables;
use Validator;
use DB;

class FinanceAccountController extends Controller
{
    public function find($id){
        $finance_accounts = FinanceAccount::where('parent_id', '=', $id)->get();

        return response()->json(['finance_accounts'=>$finance_accounts]);
    }

    public function getList()
    {
        $finance_accounts = FinanceAccount::orderBy('id','DESC')->get();
        //dd($finance_accounts);
        if (request()->ajax()) {
            return Datatables::of($finance_accounts)
                ->addColumn('action', function ($finance_accounts) {
                    if ($finance_accounts->parent_id != 0) {
                        return '<a class="btn btn-xs btn-edit" data-tooltip="tooltip" title="Ghi sổ" data-id="'.$finance_accounts->id.'" style="background: #36c6d3; color: white"> <i class="fa fa-edit" aria-hidden="true"></i></a>';
                    } else {
                        return '';
                    }
                })
                
                ->addIndexColumn()

                ->make(true);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('finance_account.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = FinanceAccount::select('id', 'name')->where('level', '=', 0)->get();

        return response()->json(['parents'=>$parents]);
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
            'level' => 'required',
            'code' => 'unique:finance_accounts'
        ];
        $messages = [
            'level.required' => 'Vui lòng chọn cấp tài khoản',
            'code.unique' => 'Mã đã tồn tại',
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

                FinanceAccount::create($data);
               
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = FinanceAccount::where('id', $id)->first();

        $parents = FinanceAccount::where('level', 0)->get();
        //dd($employee);
        return response()->json([
                    'error' => false,
                    'data' => $data,
                    'parents' => $parents
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
                FinanceAccount::where('id', $id)->update($data);
               
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
