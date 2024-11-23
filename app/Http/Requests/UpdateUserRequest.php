<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        // Allow all users to make this request. You can add additional authorization logic if needed.
        return true;
    }

    public function rules()
    {

        return [
            "name"=> [ "required", "string", "max:55"],
            "company_name"=> ["required"],
            "phone"=>["required"],
            
            "whatsapp"=> ["nullable"],
            "facebook" => ["nullable"],
            "instagram" => ["nullable"],
            "youtube" => ["nullable"],

            "location"=>["nullable"],
            "your_requirements"=> ["nullable"],
            "password"=> [
            "nullable",
            'confirmed',
            Password::min(8)
            ->letters()
            ->symbols()
            ],
            "gender"=> 'nullable|string',
            "preferred_language" => 'nullable|string',
            'user_image' => 'nullable|image|max:2048',
            "is_authorised"=> ["nullable", "boolean"],
            "is_publicly_present"=> ["nullable", "boolean"],
            "is_verified"=> ["nullable", "boolean"]
        ];
    }

    public function messages()
    {
        return [
            'password.confirmed' => 'The password confirmation does not match.',
            'profile_image.image' => 'The profile image must be an image file.',
            'profile_image.mimes' => 'The profile image must be a file of type: jpeg, png, jpg, gif.',
            'profile_image.max' => 'The profile image may not be greater than 2MB.',
            'email.unique' => 'The email address is already taken.',
            'role.in' => 'The role must be one of the following: user, admin',
        ];
    }
}
