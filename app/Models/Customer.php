<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasApiTokens; 
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
