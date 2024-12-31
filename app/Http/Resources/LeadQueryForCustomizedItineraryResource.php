<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadQueryForCustomizedItineraryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return   [
        'id' => $this->id,
        'itinerary_id' => $this->itinerary_id,
        'name' => $this->name,
        'email' => $this->email,
        'phone_number' => $this->phone_number,
        'selected_destination' => $this->selected_destination,
        'date_of_arrival' => $this->date_of_arrival,
        'places_to_cover' => $this->places_to_cover,
        'no_of_person' => $this->no_of_person,
        'no_of_adult' => $this->no_of_adult,
        'no_of_child' => $this->no_of_child,
        'child_age' => $this->child_age,
        'message' => $this->message,
        'created_at' => (new Carbon($this->created_at))->format('Y-m-d')
    ];

    }
}
