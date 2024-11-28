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
        'name', 'phone', 'password',
    ];

    public function orders() {
        return $this->hasMany(Order::class);
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
