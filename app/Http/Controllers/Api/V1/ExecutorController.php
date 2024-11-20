<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExecutorResource;
use App\Http\Resources\ExecutorInCategoryResource;
use App\Http\Resources\CategoryExecutorResource;
use Illuminate\Http\Request;
use App\Models\Executor;

class ExecutorController extends Controller
{

    public function searchByCityAndCategory(Request $request) 
    {
        // Получаем город и категорию из запроса
        $city = $request->input('city');
        $categoryId = $request->input('category_id');

        // Ищем исполнителей по адресу (городу)
        $executors = Executor::where('address', 'like', '%' . $city . '%')
                            ->whereHas('categories', function($query) use ($categoryId) {
                                // Фильтруем исполнителей, у которых есть нужная категория
                                $query->where('category_id', $categoryId);
                            })
                            ->get();

        // Собираем категории для каждого исполнителя
        $executorsWithCategory = $executors->map(function ($executor) use ($categoryId) {
            $category = $executor->categories->firstWhere('id', $categoryId); // Получаем категорию по ID
            return [
                'executor' => new ExecutorInCategoryResource($executor),
                'category' => $category, // Возвращаем категорию, к которой был привязан исполнитель
            ];
        });

        return response()->json([
            'data' => $executorsWithCategory, // Список исполнителей с их категориями
        ]);
    }
    public function updateAddress(Request $request)
    {
       // Валидация входных данных
    $validated = $request->validate([
        'address' => 'required|string|max:255', // Пожалуйста, настроите валидацию в соответствии с вашими требованиями
    ]);

    // Получаем текущего аутентифицированного исполнителя
    $executor = $request->user(); // Получаем исполнителя через токен (если он залогинен через Sanctum)

    // Проверяем, существует ли исполнитель
    if (!$executor) {
        return response()->json([
            'error' => 'Executor not found',
        ], 404);
    }

    // Обновляем только адрес
    $executor->update([
        'address' => $validated['address'],
    ]);

    // Возвращаем успешный ответ с обновлёнными данными исполнителя
    return response()->json([
        'message' => 'Address updated successfully',
        'executor' => $executor, // Возвращаем обновлённого исполнителя
    ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $executor = $request->user(); 
        return new ExecutorResource($executor);
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
    public function destroy(string $id)
    {
        //
    }
}
