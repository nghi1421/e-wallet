<?php

namespace App\Repositories\Eloquent;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

    // public function login($phone_number, $password){
    //     if()
    // }
    public function showMessage($message){
        return $message;
    }
}
