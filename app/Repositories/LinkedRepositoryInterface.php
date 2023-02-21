<?php

namespace App\Repositories;

use App\Repositories\BaseRepositoryInterface;

interface LinkedRepositoryInterface extends BaseRepositoryInterface{
    public function checkBankName($bank_name);
    public function checkExistsBank($bank_account);
    // public function
}