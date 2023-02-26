<?php

namespace App\Repositories;
use App\Repositories\BaseRepositoryInterface;

interface PaymentRepositoryInterface extends BaseRepositoryInterface{
    public function getAllPayments($phone_number);

    public function transferToBankAccount($data);

    public function transferToAnotherEWallet($data);

    // public function transferToAnotherEWallet($phone_number_source, $phone_number_des)

}