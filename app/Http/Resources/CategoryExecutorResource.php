<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryExecutorResource extends JsonResource
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
            'executor' => new ExecutorInCategoryResource($this->executor), 
            'category' => new CategoryResource($this->category),
        ];
    }
}
