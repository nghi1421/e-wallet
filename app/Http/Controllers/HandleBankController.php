<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConfigCallAPI;
use App\Models\Bank;

class HandleBankController extends Controller
{
    protected $call_api, $model_bank;
    public function __construct(ConfigCallAPI $call_api){
        $this->call_api = $call_api;
    }

    public function getBankAccount(Request $request){
        $bank = Bank::find($request->bank_id);
        $type = explode(' ',$bank['name']);
        $reuslt = $this->call_api->get('/bank-accounts/'.strtolower($type[0]).'-'.$request->bank_account_number);
        
        if(!$reuslt){
            return response()->json([
                'status' => 'falied',
                'msg' => 'call API failed'
            ]);
        }
        return response()->json([
            $reuslt
        ]);
    }

}
