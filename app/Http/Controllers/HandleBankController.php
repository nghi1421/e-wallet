<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConfigCallAPI;

class HandleBankController extends Controller
{
    protected $call_api;
    public function __construct(ConfigCallAPI $call_api){
        $this->call_api = $call_api;
    }

    public function getBankAccount(Request $request){
        $reuslt = $this->call_api->get('/bank-accounts/'.$request->type.'-'.$request->bank_account_number);
        
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
