<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItineraryRequest extends FormRequest
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
            'days_information_string' => 'required|string',
            'destination_detail' => 'required|string',
            'inclusion' => 'required|string',
            'exclusion' => 'required|string',
            'terms_and_conditions' => 'nullable|string',
            'pricing' => 'nullable',
            'hotel_details_string' => 'required|string',
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'itinerary_visibility' => 'required|string|max:255',
            'itinerary_type' => 'required|string|max:255',
            'duration_string' => 'required|string',
            'selected_destination_string' => 'required|string',
            'itinerary_theme_string' => 'required|string',
            'destination_thumbnail' => 'nullable|string|max:255', // This will be handled after upload
            'destination_images' => 'nullable', // This will be handled after upload
            'destination_thumbnail_file' => 'nullable|image|max:2048', // 2MB max size
            'destination_images_files.*' => 'nullable|image|max:2048', // Multiple images
        ];
    }
}
