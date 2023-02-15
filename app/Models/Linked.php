<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Bank;
use App\Http\Models\UserInfo;

class Linked extends Model
{
    use HasFactory;

    protected $table = "linked";
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_info_id',
        'bank_account_number',
        'bank_id',
        'checked',
    ];

    public $timestamps = true;

    public function userInfo(){
        return $this->belongsTo(UserInfo::class);
    }

    public function bank(){
        return $this->belongsTo(Bank::class);
    }
}
