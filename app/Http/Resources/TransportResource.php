<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransportResource extends JsonResource
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
            'created_at'=> $this-> created_at,
            'address'=> $this-> address,
            'price'=> $this-> price,
            'latitude'=> $this-> latitude,
            'longitude'=> $this-> longitude,
            'min_order'=> $this-> min_order,
            'category' => new CategoryResource($this->category),
            'user' => new UserForTransportResource($this->user),
        ];
    }
}
