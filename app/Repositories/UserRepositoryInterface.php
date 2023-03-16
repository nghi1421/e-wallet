<?php
namespace App\Repositories;

use App\Repositories\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{

    // public function login($phone_number, $password);

    // public function register($phone_number, $password, $user_data);

    // public function logout($user);
    public function showMessage($message);

    public function getBalance($phone_number);
    
}