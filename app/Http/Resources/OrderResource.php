<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'description'=> $this-> description,
            'address'=> $this-> address,
            'category_id'=> $this-> category_id,
            'customer_id'=> $this-> customer_id,
            'created_at'=> $this-> created_at,
        ];
    }
}
