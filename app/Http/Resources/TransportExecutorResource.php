<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransportExecutorResource extends JsonResource
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
            'price'=> $this-> price,
            'address'=> $this-> address,
            'min_order'=> $this-> min_order,
            'name' => $this->category->name,  
        ];
    }
}
