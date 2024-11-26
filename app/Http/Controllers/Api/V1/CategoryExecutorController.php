<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransportExecutorResource;
use Illuminate\Http\Request;
use App\Models\CategoryExecutor;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

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

    public function searchTransport(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = (float) $request->input('radius');
        $category = $request->input('category_id');
    
        $url = 'https://geocode-maps.yandex.ru/1.x/';
    
        $response = Http::get($url, [
            'apikey' => env('YANDEX_API_KEY'), 
            'geocode' => "{$longitude},{$latitude}", 
            'format' => 'json',
        ]);
    
        if ($response->failed()) {
            return response()->json(['error' => 'Не удалось получить данные по координатам'], 500);
        }
    
        $data = $response->json();
    
        if (empty($data['response']['GeoObjectCollection']['featureMember'])) {
            return response()->json(['error' => 'Не найдено соответствие для указанных координат'], 404);
        }
    
        $transportsQuery = CategoryExecutor::selectRaw(
            "*, ( 6371 * acos( cos( radians(?) ) * cos( radians(latitude) ) * cos( radians(longitude) - radians(?) ) + sin( radians(?) ) * sin( radians(latitude) ) ) ) AS distance",
            [$latitude, $longitude, $latitude]
        )
        ->havingRaw('distance < ?', [$radius])
        ->orderBy('distance');
    
        if ($category) {
            $transportsQuery->where('category_id', $category);
        }
    
        $transports = $transportsQuery->get();
    
        if ($transports->isEmpty()) {
            return response()->json(['error' => 'На данный момент поблизости не найдено специализированной техники.'], 404);
        }
    
        return response()->json(TransportExecutorResource::collection($transports));
    }
    
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TransportExecutorResource::collection(CategoryExecutor::with('executor', 'category')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $created_category_executor = CategoryExecutor::create($request->all());
    
        return new TransportExecutorResource($created_category_executor);
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
