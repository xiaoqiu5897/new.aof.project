<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use App\Models\User;
use App\Models\Permission;
use App\Models\PermissionRole;
use Datatables;
use Entrust;


class PermissionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:permissions-manager')->only(['update','store','destroy','getListPermission']);
        $this->middleware('permission:permissions-detail')->only('edit');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', [
            'permissions' => $permissions
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
            'name' => 'required'
        ];
        $messages = [
            'display_name.required' => 'Vui lòng nhập tên hiển thị',
            'name.required' => 'Vui lòng nhập quyền hạn',
        ];
        $validator = \Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            DB::beginTransaction();

            try{
                $check_per = Permission::where('name', $data['name'])->first();

                if(!empty($check_per)){
                    return response()->json([
                      'error' => true,
                      'message' => 'Quyền hạn đã tồn tại. Mời bạn thử lại!'
                    ]);
                }else{
                    Permission::create($data);

                    DB::commit();

                    return response()->json([
                        'error' => false,
                    ]);
                }
                
            }catch(Exception $e){
                Log::info('Can not create permission');

                DB::rollback();
                return response()->json([
                      'error' => true,
                      'message' => 'Không thể tạo quyền hạn. Mời bạn thử lại!'
                  ], 500);
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
        DB::beginTransaction();

        $data = Permission::select('display_name', 'name', 'description')->find($id);

        DB::commit();

        return response()->json($data);
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
            'name' => 'required'
        ];
        $messages = [
            'display_name.required' => 'Vui lòng nhập tên hiển thị',
            'name.required' => 'Vui lòng nhập quyền hạn',
        ];
        $validator = \Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            DB::beginTransaction();

            try{
                $check_per = Permission::select('name')->where('name', $data['name'])->get();
                $this_per = Permission::find($id);

                if(count($check_per)>=1 && $data['name'] != $this_per->name){
                    return response()->json([
                      'error' => true,
                      'message' => 'Quyền hạn đã tồn tại. Mời bạn thử lại!'
                    ]);
                }else{
                    $this_per->update($data);

                    DB::commit();

                    return response()->json([
                        'error' => false,
                    ]);
                }
                
            }catch(Exception $e){
                Log::info('Can not update permission');

                DB::rollback();
                return response()->json([
                      'error' => true,
                      'message' => 'Không thể cập nhật quyền hạn. Mời bạn thử lại!'
                  ], 500);
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

        try{
            
            Permission::find($id)->delete();
            PermissionRole::where('permission_id', $id)->delete();

            DB::commit();

            return response()->json([
                  'error'     => false,
                  'message'   => "Xóa quyền hạn thành công !"
              ]);
        }catch(Exception $e){
            Log::info($e->getMessage());

            return response()->json([
               'error'      => true,
               'message'    => $validator->errors()
            ]);
        }
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListPermission()
    {   
        $permissions = Permission::orderBy('id', 'desc');
        
            return Datatables::of($permissions)
                ->addIndexColumn()
                ->editColumn('description', function($permissions){
                    if (Entrust::can(["permissions-detail"])) {
                        return '<a onclick="viewDetail('.$permissions->id.');" class="btn btn-xs btn-info" title="Xem chi tiết" data-tooltip="tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    } else {
                        return null;
                    }
                })
                ->editColumn('created_at', function($permissions){
                    $time = $permissions->created_at;
                    $time_numb = strtotime($time);

                    return date("H:i | d-m-Y", $time_numb);
                })
                ->addColumn('action', function($permissions){
                    $string = '';

                    if (Entrust::can(["permissions-manager"])) {
                        $string = $string .'<a class="btn btn-xs yellow" onclick="showEdit('.$permissions->id.');" title="Chỉnh sửa" data-tooltip="tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                    }

                    return $string;
                })
                ->rawColumns(['action', 'description'])
                ->make(true);
        
    }
}
