<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\UserInfo;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB; 

class AuthController extends Controller
{
    protected $userRepository;


    // protected function credentials(Request $request)
    // {
    //     return $request->only($this->username(), 'new_password_name');
    // }

    // public function username(){
    //     return 'phone_number';
    // }

    public function __construct(UserRepositoryInterface $userRepository){
        return $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request){
        $data = $request->all();

        $user = User::where('phone_number', $data['phone_number'])->first();
        $result  = password_verify($data['password'], $user['password']);
        
        if($result){

            unset($user['password']);
            unset($user['updated_at']);

            return response()->json([
                'status' => 'success',
                'data'=> [
                    "userInfo" => $user,
                    'token' => $user->createToken('customer')->plainTextToken,
                ]
            ]);
        }
        else{
            return response()->json([
                'status' => 'fail',
                'msg'=> 'Xác thực không thành công.'
            ]);
        }
    }

    public function fakeOTPCode(Request $request){
        $data = $request->validate([
            'phone_number' => [
                'required',
                'max:15',
                'regex:/(0)[0-9]/',
                'not_regex:/[a-z]/',
                'min: 9',
                'unique:users,phone_number'
            ]
        ]);

        return response()->json([
            'status' => 'success',
            'data' => [
                'fakeOTPCode' => random_int(100000,999999),
            ]
        ]);
    }

    public function checkOTPCode(Request $request){
        if($request['result']){
            return response()->json([
                'status' => 'success',
                'data' => [
                    'msg' => "Xác thực OTP thành công."
                ],
            ]);
        }
        else{
            return response()->json([
                'status' => 'fail',
                'data' => [
                    'msg' => "Xác thực OTP thất bại."
                ],
            ]);
        }
    }

    public function register(RegisterRequest $request){

        if(!$request['checked']){
            return response()->json([
                'status' => 'fail',
                'data' => [
                    'msg' => "Vui lòng xác thực số điện thoại."
                ],
            ]);
        }

        [$new_token, $new_user_info] = DB::transaction(function () use($request){
            $new_user_info = $request->all();

            $new_user_info['password'] = bcrypt($request['password']);
            $new_user_info['balance'] = 0;
            $new_user = $this->userRepository->create($new_user_info);
            
            unset( $new_user['password']);

            $new_token = $new_user->createToken('customer')->plainTextToken;


            return [$new_token, $new_user];
        });

        return response()->json([
            'status' => 'success',
            'data' => [
                'userInfo:' => $new_user_info,
                'token' => $new_token,
            ],
        ]);
        
    }

}
