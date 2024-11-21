<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\CategoryExecutorResource;
use App\Http\Resources\CategoryResource;

class CategoryExecutor extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryExecutorFactory> */
    use HasFactory;

      /**
     * Связь с моделью Executor.
     */
    protected $table = 'category_executors';

    protected $fillable = [
        'executor_id',
        'category_id',
        'price',
        'address',
        'min_order',
        'name',
        'image',
    ];

    public function executor()
    {
        return $this->belongsTo(Executor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
