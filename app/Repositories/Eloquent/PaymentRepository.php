<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\PaymentRepositoryInterface;

class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface{

    protected $model_payment, $model_linked, $model_bank, $model_user;

    public function __construct($model_payment, $model_linked, $model_bank, $model_user){
        $this->model_payment = $model_payment;
        $this->model_linked = $model_linked;
        $this->model_bank = $model_bank;
        $this->model_user = $model_user;
    }

    public function getAllPayments($phone_number){
        $payments = $this->model_payment->whereColumn('phone_number', $phone_number);
        return $payments;
    }

    public function transferToBankAccount($phone_number, $bank_account_number){

    }

    public function transferToAnotherEWallet($phone_number_source, $phone_number_des, $money){
        if($phone_number_source == $phone_number_des)
            return 0;
        $source = $this->model_user->find($phone_number_source);
        $des = $this->model_user->find($phone_number_des);

        if(!$source || !$des)
            return 4;

        if($source['balance'] < $money)
            return 1;
        else{
            $source['balance'] -= $money;
            $des['balance'] += $money;
            $new_payment = $this->model_payment->create([
                'phone_number_source' => $phone_number_source,
                'phone_number_des' => $phone_number_des,
                'type' => 1,
                'note' => 1,
            ]);
            return 2;
        }

        return 3;
    }
}