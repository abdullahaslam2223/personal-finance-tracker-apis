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
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'category' => $this->category->name,
            'amount' => $this->amount,
            'date' => $this->date,
            'is_income' => $this->is_income,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
