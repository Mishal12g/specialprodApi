<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasApiTokens; 

    protected $fillable = [
        'id',
        'date',
        'customer_id',
        'executor_id',
        'transport_id',
        'location',
        'start_of_work',
        'status',
        'description',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class);
    }
    
    public function executor()
    {
        return $this->belongsTo(User::class);
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }


    use HasFactory;
}
