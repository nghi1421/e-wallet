<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Linked;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'user_info';
    protected $primaryKey = 'id';

    protected $fillable =  [
        'name',
        'phone_number',
        'dob',
        'address',
        'balance',
        'user_id'
    ];

    public $timestamps = true;

    public function linked(){
        return $this->hasMany(Linked::class);
    }
    
}
