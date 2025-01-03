<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogCategoryResource extends JsonResource
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
            "category_name" => $this->category_name,
            "created_at" => (new Carbon($this->created_at))->format("Y-m-d"),
            "updated_at" => (new Carbon($this->updated_at))->format("Y-m-d"),
        ];
    }
}
