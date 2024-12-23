<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'user_id'=>$this->user_id,
            'blog_title' => $this->blog_title,
            'blog_slug' => $this->blog_slug,
            'blog_image' => $this->blog_image,
            'blog_keywords' => $this->blog_keywords,
            'blog_description' => $this->blog_description,
            'blog_author_name' => $this->blog_author_name,
            'blog_category' => $this->blog_category,
            'blog_meta_title' => $this->blog_meta_title,
            'blog_content' => $this->blog_content,
            "blog_visibility" => $this->blog_visibility,
            'created_at'=> (new Carbon($this->created_at))->format("Y-m-d"),
        'updated_at'=> (new Carbon($this->updated_at))->format("Y-m-d"),
        ];
    }
}
