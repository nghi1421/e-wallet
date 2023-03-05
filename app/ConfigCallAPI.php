<?php

namespace App;

use Illuminate\Support\Facades\Http;

class ConfigCallAPI{
    private $bank_route = 'https://bank-production-adbd.up.railway.app/api';
    private $header = ['Accept' => 'application/json'];
    
    public function get($sub_fix){

        $response = Http::withoutVerifying()
            ->withHeaders($this->header)
            ->get($this->bank_route.$sub_fix);
        return json_decode($response,true);;
    }

    public function post($sub_fix, $data_form){

        $response = Http::withoutVerifying()
            ->withHeaders($this->header)
            ->post($this->bank_route.$sub_fix,$data_form);
        return json_decode($response,true);
    }

}