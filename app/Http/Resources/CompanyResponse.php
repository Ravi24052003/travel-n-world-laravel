<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResponse extends JsonResource
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
            'user_id' => $this->user_id,
             'company_logo' => $this->company_logo,
            'company_name' => $this->company_name,
            'company_address' => $this->company_address,
            'company_city' => $this->company_city,
            'pin_code' => $this->pin_code,
            'company_status' => $this->company_status,
            'services_offered' => $this->services_offered, // Decoded JSON array of services
            'number_of_staff' => $this->number_of_staff,
            'about_company' => $this->about_company,
            'company_website' => $this->company_website,
            'user' => $this->user,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
