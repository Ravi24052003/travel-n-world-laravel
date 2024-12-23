<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicUserResource extends JsonResource
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
            "phone"=>$this->phone,
            "whatsapp"=>$this->whatsapp,
            "facebook"=>$this->facebook,
            "instagram"=> $this->instagram,
            "youtube" => $this->youtube,
            'role' => $this->role,
             'company_logo' => $this->company?->company_logo,
            'company_name' => $this->company?->company_name,
            'company_address' => $this->company?->company_address,
            'company_city' => $this->company?->company_city,
            'pin_code' => $this->company?->pin_code,
            'company_website' => $this->company?->company_website,
           
        ];
    }
}
