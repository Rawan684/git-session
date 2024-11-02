<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => (string) $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "priority" => $this->priority,
            'relationships' => [
                "id" => (string)$this->user->id,
                "user name" => (string)$this->user->name,
                "user email" => (string)$this->user->email,
            ],
        ];
    }
}
