<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "company_name"=>$this->company_name,
            "phone"=>$this->phone,

            "whatsapp"=>$this->whatsapp,
            "facebook"=>$this->facebook,
            "instagram"=> $this->instagram,
            "youtube" => $this->youtube,
            
            "email"=>$this->email,
            "location"=>$this->location,
            "your_requirements"=>$this->your_requirements,
            "your_photo"=>$this->your_photo,
            "gender"=>$this->gender,
            "preferred_language"=>$this->preferred_language,
            "role"=>$this->role,
            "is_authorised"=> $this->is_authorised,
            "is_publicly_present"=> $this->is_publicly_present,
            "is_verified"=> $this->is_verified,
            "company"=>$this->company
        ];
    }
}
