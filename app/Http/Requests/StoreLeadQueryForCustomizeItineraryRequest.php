<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadQueryForCustomizeItineraryRequest extends FormRequest
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
            'itinerary_id' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15',
            'selected_destination' => 'required|string|max:255',
            'date_of_arrival' => 'required|date',
            'places_to_cover' => 'nullable|array',
            'no_of_person' => 'nullable|string',
            'no_of_adult' => 'nullable|string',
            'no_of_child' => 'nullable|string',
            'child_age' => 'nullable|string',
            'message' => 'nullable|string',
        ];
    }
}
