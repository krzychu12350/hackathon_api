<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'preferred_water_amount' => $this->preferred_water_amount->value,
            'location' => $this->location,
            'last_watering' => $this->last_watering,
            'expected_humidity' => $this->expected_humidity,
            'current_humidity' => $this->current_humidity,
//            'category' => [
//                'id' => $this->category->id ?? null,
//                'name' => $this->category->name ?? null,
//            ],
            'photo' => optional($this->photo)->url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
