<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Bank;
use App\Http\Models\User;

class Linked extends Model
{
    use HasFactory;

    protected $table = "linked";
    protected $primaryKey = 'id';

    protected $fillable = [
        'phone_number',
        'bank_account_number',
        'bank_id',
        'checked',
    ];

    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function bank(){
        return $this->belongsTo(Bank::class);
    }
}
