<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:500',
            'company_city' => 'required|string|max:100',
            'pin_code' => 'required|string',
            'company_status' => 'nullable|string',
            'services_offered' => 'nullable',
            'number_of_staff' => 'nullable|string',
            'about_company' => 'nullable|string|max:1000',
            'company_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required' => 'The company name is required.',
            'company_address.required' => 'The company address is required.',
            'company_city.required' => 'The company city is required.',
            'pin_code.required' => 'The pin code is required.',
            'pin_code.size' => 'The pin code must be exactly 6 characters.',
            'services_offered.array' => 'The services offered field must be an array.',
            'number_of_staff.integer' => 'The number of staff must be a valid integer.',
        ];
    }
}
