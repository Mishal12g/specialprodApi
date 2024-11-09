<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasApiTokens; 
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
}
