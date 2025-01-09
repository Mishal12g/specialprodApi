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
            'date'=> $this-> date,
            'customer'=> new UserForOrderResource($this->customer),
            'executor'=> new UserForOrderResource($this->executor),
            'transport' => new TransportResource($this->transport),
            'location'=> $this-> location,
            'start_of_work'=> $this-> start_of_work,
            'status'=> $this-> status,
            'description'=> $this-> description,

            // 'id'=> $this-> id,
            // 'description'=> $this-> description,
            // 'address'=> $this-> address,
            // 'category_id'=> $this-> category_id,
            // 'user_id'=> $this-> user_id,
            // 'created_at'=> $this-> created_at,
        ];
    }
}
