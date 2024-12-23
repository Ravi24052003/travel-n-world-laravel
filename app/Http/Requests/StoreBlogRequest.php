<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'blog_title' => 'required|string|max:255|unique:blogs,blog_title',
            'blog_slug' => 'required|string|max:255|unique:blogs,blog_slug',
            'blog_image_file' => 'required|image|max:2048',
            'blog_keywords' => 'required|string|max:255',
            'blog_description' => 'required|string',
            'blog_author_name' => 'nullable|string|max:255',
            'blog_category' => 'required|string|max:255',
            'blog_meta_title' => 'required|string|max:255',
            'blog_visibility' => 'nullable|in:private,public',
            'blog_content' => 'required|string',
        ];
    }
}
