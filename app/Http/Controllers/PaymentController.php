<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request\StoreTransferEwalletRequest;
class PaymentController extends Controller
{
    protected $paymentRepository;

    public function __construct($paymentRepository){
        $this->paymentRepository = $paymentRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($phone_number)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function transferToAnotherEWallet(StoreTransferEwalletRequest $request, $phone_number){
        $data = $request->all();
        $result = $this->paymentRepository->transferToAnotherEWallet($phone_number, $data['phone_number_des'], $data['money']);
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
                'status' => 'success',
                
                'msg' => "Giao dịch thành công."
            ]);
        }
        else if($result == 1){
            return response()->json([
                'status' => 'success',
                'msg' => "Số dư không đủ để thực hiện giao dịch."
            ]);
        }
        else if($result == 1){
            return response()->json([
                'status' => 'success',
                'msg' => "Số dư không đủ để thực hiện giao dịch."
            ]);
        }
    }
}
