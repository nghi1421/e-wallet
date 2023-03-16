<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model
{
    use HasFactory;
    protected $table = "payments";
    protected $primaryKey = "id";
    protected $fillable = [
        'phone_number_source',
        'phone_number_des',
        'bank_account_source',
        'bank_account_des',
        'type',
        'status',
        'money',
        "note",
        "bank_id",
        'created_at',
        'updated_at',
    ];

    protected $cats = [
        'money' => 'int'
    ];

    public $timestamps = true;

    public function bank(){
        return $this->belongsTo(Bank::class);
    }
    
}
