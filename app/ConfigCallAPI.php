<?php

namespace App;

use Illuminate\Support\Facades\Http;

class ConfigCallAPI{
    private $bank_route = 'localhost:3000/api';
    private $header = ['Accept' => 'application/json'];
    
    public function get($sub_fix){

        $response = Http::withHeaders($this->header)
            ->get($this->bank_route.$sub_fix)
            ->body();
        return json_decode($response,true);
    }

    public function post($sub_fix, $data_form){

        $response = Http::withHeaders($this->header)
            ->get($this->bank_route.$sub_fix)
            ->body($data_form);
        return json_decode($response,true);
    }

}