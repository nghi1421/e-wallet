<?php

namespace App\Repositories\Eloquent;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface {
    
    protected $model_user;

    public function __construct($model_user){
        $this->model_user = $model_user;
    }
    // public function login($phone_number, $password){
    //     if()
    // }
    public function showMessage($message){
        return $message;
    }

    public function getBalance($phone_number){
        $user = $this->model_user->select('balance')->where('phone_number', $phone_number)->first();
        return $user;
    }
}
