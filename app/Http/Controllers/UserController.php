<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface;;
class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository){
        $this->userRepository = $userRepository;
    }

    public function getBalance($phone_number){
        $result = $this->userRepository->getBalance($phone_number);
        if($result){
            return response()->json([
                'status' => 'success',
                'data' => $result
            ]);
        }
        else{
            return response()->json([
                'status' => 'fail',
                'msg' => "fail to user"
            ]);
        }
    }
}
