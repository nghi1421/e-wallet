<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\LinkedRepositoryInterface;
use App\Http\Requests\StoreLinked;

class LinkedController extends Controller
{
     protected $linkedRepository;

    public function __construct(LinkedRepositoryInterface $linkedRepository){
        return $this->linkedRepository = $linkedRepository;
    }

    // protected 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($phone_number)
    {
        return response()->json([
            'status' => 'success',
            'data'=> $this->linkedRepository->getAllLinkedUser($phone_number)
        ]);
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
                'status' => 'success',
                'msg' => "Tài khoản đã liên kết",
            ]);
        }

        if($request['checked']){

            $new_linked = $this->linkedRepository->storeLinked($data);
            return response()->json([
                'status' => 'success',
                'data' => $new_linked
            ]);
        }
        else{
            return response()->json([
                'status' => 'fail',
                'msg' => "Xác thực tài khoản ngân hàng thất bại."
            ]);
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
    
}
