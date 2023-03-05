<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\LinkedRepositoryInterface;
use App\ConfigCallAPI;
class LinkedRepository extends BaseRepository implements LinkedRepositoryInterface{

    protected $model_linked, $model_bank, $model_user;

    public function __construct($model_linked, $model_bank, $model_user, ConfigCallAPI $call_api){
        $this->model_linked = $model_linked;
        $this->model_bank = $model_bank;
        $this->model_user = $model_user;
        $this->call_api = $call_api;
    }

    public function getAllLinked(){
        return $this->model_linked->all();
    }

    public function getAllLinkedUser($phone_number){
        $user_info = $this->model_user->where('phone_number',$phone_number)->get();

        if($user_info == "[]"){
            return 2;
        }
        
        $result = $this->model_linked->where('phone_number', $phone_number)->get();
        // $result = $this->model_linked->whereOrderBy('phone_number',$phone_number, 'acs');
        // $result = $this->model_linked->where('phone_number', $phone_number)->orderBy('created_at', $order_by)->get();
        if($result){
            return $result;
        }
        else{
            return 1;
        }
        
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

    public function checkExistsBank($bank_account_number, $bank_id){
        $bank = $this->model_linked->where('bank_account_number', $bank_account_number)->get();
        return $bank == "[]" ? false: true;
    }

    public function storeLinked($data){

        $bank = $this->model_bank->find($data['bank_id']);
        $type = explode(' ',$bank['name']);

        // return $type;
        //get bank account information
        $bank_account_info = $this->call_api->get('/bank-accounts/'.strtolower($type[0]).'-'.$data['bank_account_number']);

        if($bank_account_info['status']=='fail')
            return 1;

        $data['checked'] = true;
        $new_linked = $this->model_linked->create($data);

        return $new_linked ? $new_linked : 2;

    }

    public function findLinkedById($id){
        return $this->model_linked->findOrFail($id);
    }

    public function removeLinked($id){
        $linked = $this->model_linked->find($id);
        if($linked){
            return $linked->delete();
        }
        return 2;
    }
}
