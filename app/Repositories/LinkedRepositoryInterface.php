<?php

namespace App\Repositories;

use App\Repositories\BaseRepositoryInterface;

interface LinkedRepositoryInterface extends BaseRepositoryInterface{
    public function getAllLinked();
    
    public function getAllLinkedUser($phone_number);

    public function checkBankName($bank_name);

    public function checkExistsBank($bank_account_number, $bank_id);

    public function storeLinked($data);

    public function findLinkedById($id);

    public function removeLinked($id);
    // public function
}