<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\TransportResource;
use App\Http\Resources\CategoryResource;

class Transport extends Model
{
    /** @use HasFactory<\Database\Factories\TransportFactory> */
    use HasFactory;

      /**
     * Связь с моделью Executor.
     */
    protected $table = 'transports';

    protected $fillable = [
        'category_id',
        'user_id',
        'price',
        'address',
        'latitude',
        'longitude',
        'min_order',
        'name',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
