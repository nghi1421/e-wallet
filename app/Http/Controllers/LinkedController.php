<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\LinkedRepositoryInterface;
use App\Http\Requests\StoreLinked;

use Illuminate\Support\Facades\Http;

class LinkedController extends Controller
{
     protected $linkedRepository, $call_api;

    public function __construct(LinkedRepositoryInterface $linkedRepository){
        $this->linkedRepository = $linkedRepository;
    }

    // protected 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($phone_number)
    {
        $result = $this->linkedRepository->getAllLinkedUser($phone_number);
        if(is_object($result)){
            return response()->json([
                'status' => 'success',
                'data'=> $result
            ]);
        }
        else{
            if($result == 1)
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg'=> "Fail connecting"
                ]);
            elseif( $result == 2 )
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => $result,
                    'msg'=> "User not found",
                ]);
            
        }
       
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
    public function store(StoreLinked $request)
    {
        $data = $request->all();
        $bank = $this->linkedRepository->checkExistsBank($data['bank_account_number'], $data['bank_id']);

        // return response()->json([
        //     'data' => $bank
        // ]);

        if($bank){
            return response()->json([
                'status' => 'fail',
                'codeErr' => 1,
                'msg' => "Bank account linked!!!",
            ]);
        }

        $result = $this->linkedRepository->storeLinked($data);
        
        if(is_object($result)){
            return response()->json([
                'status' => 'success',
                'data' => $result,
            ]);
        }
        else{
            if($result ==1){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => 2,
                    'msg' => 'Bank account not found',
                ]);
            }
            elseif($result == 2){
                return response()->json([
                    'status' => 'fail',
                    'codeErr' => 3,
                    'msg' => 'failed store'
                ]);
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'status' => 'success',
            'data'=> $this->linkedRepository->findLinkedById($id)
        ]);
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
        $result = $this->linkedRepository->removeLinked($id);
        if($result ==2 ){
            return response()->json([
                'status' => 'success',
                'msg' => 'Không tồn tại',
            ]);
        }

        if($result)
            return response()->json([
                'status' => 'success',
                'msg' => 'Xóa liên kết tài khoản thành công.'
            ]);
        return response()->json([
            'status' => 'fail',
            'msg' => 'Xóa liên kết tài khoản thất bại'
        ]);
    }

    public function getLinked($phone_number){
        return $this->linkedRepository->getAllLinkedUser($phone_number);
    }

    public function testCallAPI(){
        $response = Http::withoutVerifying()
            ->withHeaders(['Accept' => 'application/json'])
            ->post('ntkewallet.fun/e-wallet/public/api/login',
            [
                "phone_number" => "0987123123",
                "password" => "ThanhNghi123`"
            ]);
        return json_decode($response, true);
    }
    
}
