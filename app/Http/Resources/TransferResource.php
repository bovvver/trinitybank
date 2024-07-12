<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isSender = true;
        if ($this->is_sender == 0)
            $isSender = false;

        return [
            "message" => $this->message,
            "amount" => $this->amount,
            "currency" => $this->currency,
            "transactionDate" => $this->transaction_date,
            "fullName" => "{$this->name} {$this->surname}",
            "isSender" => $isSender,
            "category" => $this->category,
            "accountNumber" => $this->account_number,
        ];
    }
}
