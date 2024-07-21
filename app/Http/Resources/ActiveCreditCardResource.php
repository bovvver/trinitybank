<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActiveCreditCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "cardLastDigits" => $this->card_last_digits,
            "balance" => $this->balance,
            "currency" => $this->currency,
            "cardColor" => $this->card_color,
            "active" => $this->active,
        ];
    }
}
