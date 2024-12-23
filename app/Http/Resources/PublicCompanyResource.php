<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicCompanyResource extends JsonResource
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
            'company_website' => $this->company_website,
            "user_phone"=>$this->user->phone,
            "user_whatsapp"=>$this->user->whatsapp,
            "user_facebook"=>$this->user->facebook,
            "user_instagram"=> $this->user->instagram,
            "user_youtube" => $this->user->youtube,
            'user_role' => $this->user->role,
            'user_isAuthorised' => $this->user->isAuthorised
        ];
    }
}
