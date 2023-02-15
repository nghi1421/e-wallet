<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Linked;

class Bank extends Model
{
    use HasFactory;
    
    protected $table = "banks";
    protected $primaryKey = "id";
    
    protected $fillable = [
        'name',
        'phone_number',
        'head_address',
    ];

    public $timestamps = true;
    
    public function linked(){
        return $this->hasMany(Linked::class);
    }
}
