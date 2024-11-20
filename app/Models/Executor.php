<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Executor extends Model
{
    /** @use HasFactory<\Database\Factories\ExecutorFactory> */
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'name', 'phone', 'password', 'address',
    ];
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_executors');
    }

    public function categoryLinks()
    {
        return $this->hasMany(CategoryExecutor::class, 'executor_id');
    }
}
