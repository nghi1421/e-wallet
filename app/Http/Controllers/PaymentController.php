<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTransferEwalletRequest;
use App\Http\Requests\DepositMoneyRequest;
use App\Http\Requests\TransferToBankAccountRequest;
use App\Repositories\PaymentRepositoryInterface;

class PaymentController extends Controller
{
    protected $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository){
        $this->paymentRepository = $paymentRepository;
    }

    public function getAllPayments($phone_number){
        return response()->json([
            'status' => 'success',
            'data'=> $this->paymentRepository->getAllPayments($phone_number),
        ]);
    }

    public function transferToAnotherEWallet(StoreTransferEwalletRequest $request){
        $data = $request->all();
        if($data['money']<=0 ){
            return response()->json([
                'status' => 'fail',
                'msg' => 'Số tiền không hợp lệ!',
            ]);
        }
        $result = $this->paymentRepository->transferToAnotherEWallet($data);

        if( is_object($result)){
            if($result){
                return response()->json([
                    'status' => 'success',
                    'data' => $result,
                ]);
            }
        }

        if($result == 0){
            return response()->json([
                'status' => 'fail',
                'msg' => "Ví điện tử thụ hưởng không hợp lệ."
            ]);
        }
        else if($result == 1){
            return response()->json([
                'status' => 'fail',
                'msg' => "Số dư không đủ để thực hiện giao dịch."
            ]);
        }
        else if($result == 2){
            return response()->json([
                'status' => 'fail',
                'msg' => "Tài khoản không hợp lệ."
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'msg' => "Giao dịch thất bại."
        ]);
           
    }

    public function depositMoney(DepositMoneyRequest $request){
        $data = $request->all();
        if($data['money']<=0 ){
            return response()->json([
                'status' => 'fail',
                'msg' => 'Số tiền không hợp lệ!',
            ]);
        }

        $result  = $this->paymentRepository->depositMoney($data);
        
        if(is_object($result)){
            return response()->json([
                'status' => 'success',
                'codeErr' => 0,
                'data' => $result,
            ]);
        }
        else{
            if($result == 1 ){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'Bank account linked does not exists'
                ]);
            }
            elseif($result == 2){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'Bank account does not enough money'
                ]);
            }
            elseif($result == 3){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'User does not exists'
                ]);
            }
            elseif($result == 4){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'Transaction bank is failed'
                ]);
            }
            elseif($result == 5){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'Failed'
                ]);
            }
            elseif($result == 6){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'wrong input current phone_number!!!'
                ]);
            }
            elseif($result == 7){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'Bank is not exists'
                ]);
            }
            elseif($result == 8){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'Not enough money'
                ]);
            }
        }
    }

    public function transferBankAccount(TransferToBankAccountRequest $request){
        $data = $request->all();

        if($data['money']<=0 ){
            return response()->json([
                'status' => 'fail',
                'codeErr' => 0,
                'msg' => 'Invalid money!',
            ]);
        }

        $result = $this->paymentRepository->transferToBankAccount($data);
        if(is_object($result)){
            return response()->json([
                'status' => 'success',
                'codeErr' => 0,
                'data' => $result,
            ]);
        }
        else{
            if($result == 1 ){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'Bank account linked does not exist'
                ]);
            }
            elseif($result == 2){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'User not found'
                ]);
            }
            elseif($result == 3){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'Not enough money'
                ]);
            }
            elseif($result == 4){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'Invalid money'
                ]);
            }
            elseif($result == 5){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'Bank account not exist'
                ]);
            }
            elseif($result == 6){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'Transaction bank is failed!!!'
                ]);
            }
            elseif($result == 7){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg' => 'Transaction fail'
                ]);
            }
        }
    }
}
