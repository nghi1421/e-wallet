<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\LinkedRepositoryInterface;

class LinkedRepository extends BaseRepository implements LinkedRepositoryInterface{

    protected $model_linked, $model_bank, $model_user;

    public function __construct($model_linked, $model_bank, $model_user){
        $this->model_linked = $model_linked;
        $this->model_bank = $model_bank;
        $this->model_user = $model_user;
    }

    public function getAllLinked(){
        return $this->model_linked->all();
    }

    public function getAllLinkedUser($phone_number){
        $user_info = $this->model_user->where('phone_number',$phone_number)->first();


        if($user_info){
            return response()->json([
                'status' => 'success',
                'data' => $this->model_linked->where('phone_number',$phone_number)->get()
            ]);
        }
        else{
            return response()->json([
                'status' => 'fail',
                'msg' => 'Not found user'
            ]);
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
        $bank = $this->model_bank->whereColumn('bank_account_number', $bank_account_number);
        return $bank;
    }

    public function storeLinked($data){

        $new_linked = $this->model_linked->create($data);
        unset($new_linked['checked']);
        return $new_linked;

    }

    public function findLinkedById($id){
        return $this->model_linked->findOrFail($id);
    }

    public function removeLinked($id){
        $linked = $this->model_linked->find($id);
        if($linked){
            return $linked->delete();
        }
        return false;
    }
}
