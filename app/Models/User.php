<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Models\Linked;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'users';
    protected $primaryKey   = 'phone_number';

    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone_number',
        'name',
        'password',
        'dob',
        'address',
        'balance'
    ];

    protected $casts = [
        'phone_number' => 'string',
        'balance' => 'int'
    ];

    // protected $hidden = [
    //     'password'
    // ];

    public function linked(){
        return $this->hasMany(Linked::class);
    }

}
