<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'equipment_type' => [
                'id' => $this->equipmentType->id,
                'name' => $this->equipmentType->name,
            ],
            'serial_number' => $this->serial_number,
            'note' => $this->note,
            'created_at' => $this->created_at,
        ];
    }
}
