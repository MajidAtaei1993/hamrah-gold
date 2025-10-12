<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user" => new UserResource($this->user),
            "type" => $this->type,
            "weight" => $this->weight,
            "price" => $this->ir_price,
            "fee" => $this->fee,
            "total" => $this->total_price,
            'created_at' => $this->created_at
        ];
    }
}
