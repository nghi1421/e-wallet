<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\PaymentRepositoryInterface;
use Illuminate\Support\Facades\DB;  

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

    public function transferToBankAccount($data){

    }

    public function transferToAnotherEWallet($data){
        if($data['phone_number_source'] == $data['phone_number_des'])
            return 0;
        $source = $this->model_user->find($data['phone_number_source']);
        $des = $this->model_user->find($data['phone_number_des']);

        // return $source;
        if(!$source || !$des)
            return 2;

        // return $source['balance'];

        if($source['balance'] < $data['money'])
            return 1;
        else{
            
            $new_payment = DB::transaction(function () use ($data, $source, $des){
                $new_payment = $this->model_payment->create([
                    'phone_number_source' => $data['phone_number_source'],
                    'phone_number_des' => $data['phone_number_des'],
                    'type' => 1,
                    'note' => $data['note'],
                    'money' => $data['money'],
                    'status' => 0,
                ]);
                $source['balance'] -= $data['money'];
                $des['balance'] += $data['money'];
    
                $source->update();
                $des->update();
    
                $new_payment['status'] = 1;
                $new_payment->update();

                return $new_payment;
            });
            
            return $new_payment;
        }

        return 3;
    }
}