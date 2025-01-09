<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersListResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showCustomerOrders(string $customerId)
    {
        // Получаем все заказы для конкретного заказчика
        $orders = Order::where('customer_id', $customerId)->get();
        return OrderResource::collection($orders);
    }
    
    public function showExecutorOrders(string $executorId)
    {
        // Получаем все заказы для конкретного исполнителя
        $orders = Order::where('executor_id', $executorId)->get();
        return OrderResource::collection($orders);
    }


    public function index()
    {
        // return OrderResource::collection(Order::with('orders')-> all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $created_order = Order::create($request->all());
    
        return new OrdersListResource($created_order);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new OrderResource( Order::with('orders')-> findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, string $id)
    {
        // Найти заказ по ID
        $order = Order::find($id);
        
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
    
        // Валидация данных
        $validatedData = $request->validate([
            'status' => 'required|string|in:created,canceled,confirm,inProgress,done',
        ]);
    
        // Обновить данные заказа
        $order->update($validatedData);
    
        // Вернуть успешный ответ
        return response()->json([
            'message' => 'Order updated successfully',
            'data' =>  new OrdersListResource($order),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
