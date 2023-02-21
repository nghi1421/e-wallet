<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\LinkedRepositoryInterface;
use App\Models\Bank;

class LinkedRepository extends BaseRepository implements LinkedRepositoryInterface{

    protected $model_linked, $model_bank;

    public function __construct($model_linked, $model_bank){
        $this->model_linked = $model_linked;
        $this->model_bank = $model_bank;
    }

    public function getAllLinked(){
        return $this->model_linked->all();
    }

    public function checkBankName($bank_name){
        $bank = $this->model_bank->whereColumn('name', $bank_name);
        if($bank){
            return response()->json([
                'status' => "success",
                "data" => $bank
            ]); 
        }
        else{
            return response()->json([
                'status' => "fail",
                'msg' => "Bank account not found",
            ]);
        }
    }

    public function checkExistsBank($bank_account){
        $bank = $this->model_bank->whereColumn('bank_account_number', $bank_account);
        if($bank){
            return response()->json([
                'status' => "fail",
                "msg" => "Tài khoản ngân hàng đã được liên kết.",
            ]); 
        }
        else{
            return response()->json([
                'status' => "sucess",
                'msg' => "Tài khoản ngân hàng có thể liên kết.",
            ]);
        }
    }
}
