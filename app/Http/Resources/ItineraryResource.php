<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItineraryResource extends JsonResource
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
        "user_id" => $this->user_id,
        "days_information" => $this->days_information,
        "destination_detail" => $this->destination_detail,
        "inclusion" => $this->inclusion,
        "exclusion" => $this->exclusion,
        'terms_and_conditions' => $this->terms_and_conditions,
        'pricing' => $this->pricing,
        "hotel_details" => $this->hotel_details,
        "title" => $this->title,
        "meta_title" => $this->meta_title,
        "keyword" => $this->keyword,
        "meta_description" => $this->meta_description,
        "itinerary_visibility" => $this->itinerary_visibility,
        "itinerary_type" => $this->itinerary_type,
        "duration" => $this->duration,
        "selected_destination" => $this->selected_destination,
        "itinerary_theme" => $this->itinerary_theme,
        "destination_thumbnail" => $this->destination_thumbnail,
        "destination_images" => $this->destination_images,
        'created_at'=> (new Carbon($this->created_at))->format("Y-m-d"),
        'updated_at'=> (new Carbon($this->updated_at))->format("Y-m-d"),
        "user_name"=>$this->user->name,
        "user_company_name"=>$this->user->company_name,
        "user_phone"=>$this->user->phone,
        "user_whatsapp"=>$this->user->whatsapp,
        "user_facebook"=>$this->user->facebook,
        "user_instagram"=> $this->user->instagram,
        "user_youtube" => $this->user->youtube,
        "user_email"=>$this->user->email,
        "user_location"=>$this->user->location,
        ];
    }
}
