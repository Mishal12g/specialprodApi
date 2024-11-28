<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransportResource;
use Illuminate\Http\Request;
use App\Models\Transport;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class TransportController extends Controller
{

    public function updateAddress(Request $request, $id)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'address' => 'required|string|max:255', // Настройте валидацию в соответствии с вашими требованиями
        ]);
    
        // Находим запись Transport по ID
        $transport = Transport::find($id);
    
        // Проверяем, существует ли запись
        if (!$transport) {
            return response()->json([
                'message' => 'Category Executor not found',
            ], 404);
        }
    
        // Обновляем только адрес
        $transport->update([
            'address' => $validated['address'],
        ]);
    
        // Возвращаем успешный ответ с обновлёнными данными исполнителя
        return response()->json([
            'message' => 'Address updated successfully',
            'transport' => $transport, // Возвращаем обновлённого исполнителя
        ]);
    }

    public function searchTransport(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = (float) $request->input('radius');
        $category = $request->input('category_id');
        $currentUserId = $request->input('user_id'); // Текущий пользователь передается как параметр
    
        if (!$currentUserId) {
            return response()->json(['error' => 'Не указан идентификатор пользователя'], 400);
        }
    
        $transportsQuery = Transport::selectRaw(
            "*, ( 6371 * acos( cos( radians(?) ) * cos( radians(latitude) ) * cos( radians(longitude) - radians(?) ) + sin( radians(?) ) * sin( radians(latitude) ) ) ) AS distance",
            [$latitude, $longitude, $latitude]
        )
        ->havingRaw('distance < ?', [$radius])
        ->orderBy('distance');
    
        // Исключаем транспорт текущего пользователя
        $transportsQuery->whereHas('user', function ($query) use ($currentUserId) {
            $query->where('id', '!=', $currentUserId);
        });
    
        // Фильтруем по категории, если указана
        if ($category) {
            $transportsQuery->where('category_id', $category);
        }
    
        $transports = $transportsQuery->get();
    
        if ($transports->isEmpty()) {
            return response()->json(['error' => 'На данный момент поблизости не найдено специализированной техники.'], 404);
        }
    
        return response()->json(TransportResource::collection($transports));
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TransportResource::collection(Transport::with('executor', 'category')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $created_transport = Transport::create($request->all());
    
        return new TransportResource($created_transport);
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
    public function destroy(Transport $transport)
    {
        $transport->delete();
    }
}
