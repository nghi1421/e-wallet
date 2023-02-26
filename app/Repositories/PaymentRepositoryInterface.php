<?php

namespace App\Repositories;
use App\Repositories\BaseRepositoryInterface;

interface PaymentRepositoryInterface extends BaseRepositoryInterface{
    public function getAllPayments($phone_number);

    public function transferToBankAccount($phone_number, $bank_account_number);

    public function transferToAnotherEWallet($phone_number_source, $phone_number_des, $money);

    // public function transferToAnotherEWallet($phone_number_source, $phone_number_des)

}