<?php
namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\BankRepositoryInterface;
use App\Models\Bank;

class BankRepository extends BaseRepository implements BankRepositoryInterface{
    protected $model_bank;

    public function __construct($model_bank){
        $this->model_bank = $model_bank;
    }

    public function getAllBank(){
        return $this->model_bank->all();
    }
}
