<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasApiTokens, Notifiable;
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;
    
    protected $fillable = [
        'name', 'phone', 'password',
    ];

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
