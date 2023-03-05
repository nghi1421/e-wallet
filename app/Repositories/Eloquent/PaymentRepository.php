<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\PaymentRepositoryInterface;
use Illuminate\Support\Facades\DB;  
use App\ConfigCallAPI;
class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface{

    protected $model_payment, $model_linked, $model_bank, $model_user;

    public function __construct($model_payment, $model_linked, $model_bank, $model_user, ConfigCallAPI $call_api){
        $this->model_payment = $model_payment;
        $this->model_linked = $model_linked;
        $this->model_bank = $model_bank;
        $this->model_user = $model_user;
        $this->call_api = $call_api;
    }

    public function getAllPayments($phone_number){
        $payments = $this->model_payment->where('phone_number_source','=', $phone_number)
                                        ->orWhere('phone_number_des', '=', $phone_number)
                                        ->orderBy('updated_at', 'desc')->get();
        foreach($payments as $index => $payment){
            if($payment['status']==0){
                $payment['status'] = "Giao dịch thất bại";
            }
            else{
                $payment['status'] = "Giao dịch thành công";
            }
            if(!is_null($payment['bank_account_source'])){
                
                $payments[$index]['bank_info'] = $this->model_bank->find($payments[$index]['bank_id']);
                unset($payments[$index]['phone_number_source']);
                unset($payments[$index]['bank_account_des']); 

            }
            if(!is_null($payment['bank_account_des'])){

                $payments[$index]['bank_info'] = $this->model_bank->find($payments[$index]['bank_id']);
                unset($payments[$index]['phone_number_des']);
                unset($payments[$index]['bank_account_source']); 
            }
            
            unset($payments[$index]['bank_id']); 
        }
        return $payments;
    }

    public function transferToBankAccount($data){
        $bank = $this->model_bank->find($data['bank_id']);
        $type = explode(' ',$bank['name']);

        //get bank account information
        $bank_account_info = $this->call_api->get('/bank-accounts/'.strtolower($type[0]).'-'.$data['bank_account_des']);

        if($bank_account_info['status']=='fail')
            return 1;
        
        //check user
        $user = $this->model_user->find($data['phone_number_source']);
        if(!$user)    
            return 2;

        //check balance
        if($user['balance'] < $data['money'])
            return 3;
        
        $result = $this->call_api->post('/bank-accounts/receive', [
            'bank_account_number' => $data['bank_account_des'],
            'money' => $data['money']
        ]);

        //check status call api
        if($result['status']=='fail'){
            if($result['code']=='001')
                return 4;
            elseif($result['code']=='002')
                return 5; 
            elseif($result['code']=='003')
                return 6; 
        }

        $new_payment = DB::transaction(function () use ($data, $user){
            $user['balance'] -= $data['money'];
            $user->update();
            $payment = $this->model_payment->create([
                'phone_number_source' => $data['phone_number_source'],
                'bank_account_des' => $data['bank_account_des'],
                'note' => $data['note'],
                'money' => $data['money'],
                'type' => 2,
                'status' => 0,
                'bank_id'=> $data['bank_id'],
            ]);      
            $payment['status'] = 1;
            $payment->update();
            return $payment;
        });
        
        //write more function to rollback from bank
        return $new_payment ? $new_payment : 7;
    }

    public function depositMoney($data){
        //check right linked ?
        $check = $this->model_linked->find($data['linked_id']);
        if($check['phone_number']!=$data['phone_number_des']){
            return 6;
        }

        //get bank type =  the first word bank name
        $bank = $this->model_bank->find($check['bank_id']);
        $type = explode(' ',$bank['name']);

        //get bank account information
        $bank_account_info = $this->call_api->get('/bank-accounts/'.strtolower($type[0]).'-'.$check['bank_account_number']);

        if(!$bank_account_info)
            return 1;

        //can implement?
        if($bank_account_info['data']['balance']<$data['money'])
            return 2;

        //get user information
        $user = $this->model_user->find($data['phone_number_des']);
        if(!$user)
            return 3;

        //call api implement transaction from bank
        $result = $this->call_api->post('/bank-accounts/transfer-money', [
            'bank_account_number' => $bank_account_info['data']['bank_account_number'],
            'money' => $data['money']
        ]);

        //check status call api
        if($result['status']=='fail'){
            if($result['code']=='002')
                return 7;
            elseif($result['code']=='003')
                return 8; 
            elseif($result['code']=='005')
                return 4; 
        }

        //implent transaction on ewallet
        $new_payment = DB::transaction(function () use ($data, $user, $bank_account_info, $check){
            $user['balance'] += $data['money'];
            $user->update();
            $payment = $this->model_payment->create([
                'phone_number_des' => $user['phone_number'],
                'bank_account_source' => $bank_account_info['data']['bank_account_number'],
                'bank_id' => $check['bank_id'],
                'note' => $data['note'],
                'money' => $data['money'],
                'type' => 3,
                'status' => 0,
            ]);      
            $payment['status'] = 1;
            $payment->update();
            return $payment;
        });
        
        return $new_payment ? $new_payment : 5;
    }

    public function transferToAnotherEWallet($data){
        if($data['phone_number_source'] == $data['phone_number_des'])
            return 0;
        $source = $this->model_user->find($data['phone_number_source']);
        $des = $this->model_user->find($data['phone_number_des']);

        // return $source;
        if(!$source || !$des)
            return 2;

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