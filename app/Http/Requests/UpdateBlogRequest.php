<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'blog_title' => 'sometimes|string|max:255|unique:blogs,blog_title,'. $this->route('blog')->id,
            'blog_slug' => 'sometimes|string|max:255|unique:blogs,blog_slug,'.$this->route('blog')->id,
            'blog_image_file' => 'sometimes|image|max:2048',
            'blog_keywords' => 'sometimes|string|max:255',
            'blog_description' => 'sometimes|string',
            'blog_author_name' => 'nullable|string|max:255',
            'blog_category' => 'sometimes|string|max:255',
            'blog_meta_title' => 'sometimes|string|max:255',
            'blog_visibility' => 'nullable|in:private,public',
            'blog_content' => 'sometimes|string',
        ];
    }
}
