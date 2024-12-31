<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneralLeadResource extends JsonResource
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
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "selected_destination" => $this->selected_destination,
            "date_of_arrival" => (new Carbon($this->date_of_arrival))->format('Y-m-d'),
            "created_at" => (new Carbon($this->created_at))->format('Y-m-d'),
        ];
    }
}
