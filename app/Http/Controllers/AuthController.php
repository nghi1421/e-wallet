<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        
    }

    public function register(RegisterRequest $request){
        $data_user['phone_number'] = $request['phone_number'];
        $data_user['password'] = $request['password'];

        
    }
}
