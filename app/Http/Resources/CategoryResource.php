<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->resource->id,
            "name" => $this->resource->name,
            'created_at' => $this->formatDateToTimestamp($this->resource->created_at),
            'updated_at' => $this->formatDateToTimestamp($this->resource->updated_at),
        ];
    }
}
