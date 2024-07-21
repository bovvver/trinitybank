<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'fullName' => "{$this->name} {$this->surname}",
            'email' => $this->email,
            'ssnNumber' => $this->ssn_number,
            'phoneNumber' => $this->phone_number,
            'street' => "{$this->street} {$this->house_number}",
            'city' => $this->city,
            'zipCode' => $this->zip_code,
        ];
    }
}
