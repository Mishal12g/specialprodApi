<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this-> id,
            'first_name'=> $this-> first_name,
            'last_name'=> $this-> last_name,
            'number'=> $this-> number,
            'created_at'=> $this-> created_at,
            'orders'=>  OrdersListResource::collection($this->orders),
        ];
    }
}
