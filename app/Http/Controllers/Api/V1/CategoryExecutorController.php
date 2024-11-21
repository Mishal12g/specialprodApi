<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryExecutorResource;
use Illuminate\Http\Request;
use App\Models\CategoryExecutor;

class CategoryExecutorController extends Controller
{

    public function updateAddress(Request $request, $id)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'address' => 'required|string|max:255', // Настройте валидацию в соответствии с вашими требованиями
        ]);
    
        // Находим запись CategoryExecutor по ID
        $categoryExecutor = CategoryExecutor::find($id);
    
        // Проверяем, существует ли запись
        if (!$categoryExecutor) {
            return response()->json([
                'message' => 'Category Executor not found',
            ], 404);
        }
    
        // Обновляем только адрес
        $categoryExecutor->update([
            'address' => $validated['address'],
        ]);
    
        // Возвращаем успешный ответ с обновлёнными данными исполнителя
        return response()->json([
            'message' => 'Address updated successfully',
            'category_executor' => $categoryExecutor, // Возвращаем обновлённого исполнителя
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoryExecutorResource::collection(CategoryExecutor::with('executor', 'category')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $created_category_executor = CategoryExecutor::create($request->all());
    
        return new CategoryExecutorResource($created_category_executor);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryExecutor $category_executor)
    {
        $category_executor->delete();
    }
}
