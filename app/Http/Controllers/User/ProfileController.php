<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use View;
use Validator;
use DB;
use Hash;
 

use App\Models\User;

class ProfileController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */



    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  page profiles
     *
     * @return [type] [description]
     */

    public function getProfiles() {
 // var_dump(Auth::user());
        return view('users.profiles', [
                'user' => Auth::user()
            ]);

    }

    /**
     * update information student
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */

    public function updateavatar(Request $request) {
 
       
    //   $path = $request->avatar->storeAs('images','image_'.time().'.png');
     $User=User::whereId($request->id)->update(['avatar'=>$request->avatar]);

    return response()->json([
                      'error' => false,
                  ], 200);

    

    }
    public function putUpdateProfiles(Request $request) {

        $data = $request->all();
        $rules = [
            'name' => 'required',
            'mobile' => 'required',
            ];

        $messages = [
            'name.required' => 'Vui lòng nhập họ tên',
            'mobile.required' => 'Vui lòng nhập số điện thoại',
            ];


        $validator = Validator::make($data, $rules, $messages);


        if ($validator->fails()) {

            return response()->json([
                    'error' => true,
                    'message' => $validator->errors(),
                ], 200);
        }

        DB::beginTransaction();
        try {

            $user = User::where('id', $data['id'])->first();

            //update birthday
            if (empty($data['birthday'])) {
                $data['birthday'] = NULL;
            }

            $user->update($data);

            DB::commit();

            return response()->json([
                    'error' => false,
                    'data' => $user
                ], 200);

        } catch(Exception $e) {
            Log::info('Can not update user');
            DB::rollback();
            response()->json([
                    'error' => true,
                    'message' => 'Internal Server Error'
                ], 500);
        }
    }

    /**
     * function change password
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function putUpdatePassword(Request $request) {

        $data = $request->all();

        $rules = [
            'password_old'  =>  'required|min:6',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ];

        $messages = [
            'password_old.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'password_old.min' => 'Mật khẩu hiện tại phải có ít nhất 6 ký tự',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự',
            'password_confirmation.required' => 'Vui lòng nhập lại mật khẩu mới',
            'password_confirmation.same' => 'Mật khẩu mới không khớp',
            ];


        $validator = Validator::make($data, $rules, $messages);


        if ($validator->fails()) {

            return response()->json([
                    'error' => true,
                    'message' => $validator->errors(),
                ], 200);
        }

        DB::beginTransaction();

        try {
          if ($data['id'] != Auth::id()){
            return response()->json([
                    'error' => true,
                    'type'  => 'err_pass_old',
                    'message' => "You are Robot, get out ! ",
                ], 200);
          }else{
            $user = User::where('id', $data['id'])->first();

            $password = bcrypt($data['password']);

            if (!Hash::check($data['password_old'], $user['password'])) {

              return response()->json([
                      'error' => true,
                      'type'  =>  'err_pass_old',
                      'message' => "Mật khẩu hiện tại không đúng ",
                  ], 200);
              }
             else{
              $user->password = $password;

              $user->save();

              DB::commit();

              return response()->json([
                      'error' => false,
                      'data' => $user
                  ], 200);
            }
          }



        } catch(Exception $e) {
            Log::info('Can not update password');
            DB::rollback();
            return response()->json([
                    'error' => true,
                    'message' => 'Internal Server Error'
                ], 500);
        }


    }
}
