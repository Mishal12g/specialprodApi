<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasApiTokens, Notifiable;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    
    protected $fillable = [
        'name', 'phone', 'password', 'image',
    ];

    public function customerOrders() {
        return $this->hasMany(Order::class, 'customer_id');
    }
    
    public function executorOrders() {
        return $this->hasMany(Order::class, 'executor_id');
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'transports');
    }

    public function categoryLinks()
    {
        return $this->hasMany(Transport::class, 'user_id');
    }
}
