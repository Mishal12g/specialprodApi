<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Transport;

class OrdersListResource extends JsonResource
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
        ];
    }
}
