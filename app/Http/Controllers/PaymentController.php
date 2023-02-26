<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTransferEwalletRequest;
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
}
