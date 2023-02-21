<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\UserInfo;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB; 

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository){
        return $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request){
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        if(Auth::attempt(['phone_number' => $data['phone_number'], 'password' => $data['password']])){
            $user_info = UserInfo::where('phone_number', $data['phone_number'])->first();
            return response()->json([
                'status' => 'success',
                'data'=> $user_info
            ]);
        }
        else{
            return response()->json([
                'status' => 'fail',
                'msg'=> 'Đăng nhập thất bại.'
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

            $data_user['phone_number'] = $request['phone_number'];
            $data_user['password'] = bcrypt($request['password']);
            $new_user = $this->userRepository->create($data_user);

            $new_token = $new_user->createToken('customer')->plainTextToken;

            $new_user_info = $request->all();
            $new_user_info['user_id'] = $new_user['id'];

            UserInfo::create($new_user_info);

            unset($new_user_info['password']);
            unset($new_user_info['checked']);
            unset($new_user_info['user_id']);
            unset($new_user_info['password_confirmation']);

            return [$new_token, $new_user_info];
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
