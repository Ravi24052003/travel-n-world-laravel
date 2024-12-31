<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadPhoneEmailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        "id" => $this->resource->id,
        "itinerary_id" => $this->itinerary_id,
        "email" => $this->email,
        "phone" => $this->phone,
        'created_at'=> (new Carbon($this->created_at))->format("Y-m-d"),
        ];
    }
}
