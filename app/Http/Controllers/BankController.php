<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BankRepositoryInterface;
class BankController extends Controller
{
    protected $bankRepository;

    public function __construct(BankRepositoryInterface $bankRepository){
        $this->bankRepository = $bankRepository;
    }

    public function getAllBank(){
        return response()->json([
            'status' => 'success',
            'data' => $this->bankRepository->getAllBank(),
        ]);
    }
}
