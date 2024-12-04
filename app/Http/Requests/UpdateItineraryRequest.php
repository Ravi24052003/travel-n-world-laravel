<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItineraryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Ensure proper authorization logic if required
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'days_information_string' => 'sometimes|string',
            'destination_detail' => 'sometimes|string',
            'inclusion' => 'sometimes|string',
            'exclusion' => 'sometimes|string',
            'terms_and_conditions' => 'sometimes|string',
            'pricing' => 'sometimes|numeric',
            'hotel_details_string' => 'sometimes|string',
            'title' => 'sometimes|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'itinerary_visibility' => 'sometimes|string|max:255',
            'itinerary_type' => 'sometimes|string|max:255',
            'duration_string' => 'sometimes|string',
            'selected_destination_string' => 'sometimes|string',
            'itinerary_theme_string' => 'sometimes|string',
            'destination_thumbnail' => 'nullable|string|max:255', // This will be handled after upload
            'destination_images' => 'nullable', // This will be handled after upload
            'destination_thumbnail_file' => 'nullable|image|max:2048', // 2MB max size
            'destination_images_files.*' => 'nullable|image|max:2048', // Multiple images
        ];
    }
}
