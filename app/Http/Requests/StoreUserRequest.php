<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(Auth::user()->role == "admin"){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"=> [ "required", "string", "max:55"],
            "email"=> ["required", "email", "unique:users,email"],
            "password"=> [
            "required",
            'confirmed',
            Password::min(8)
            ->letters()
            ->symbols()
            ],
            "mobile"=> ["nullable", "numeric"],
            "role" => ["nullable", "string", "in:user"]
        ];
    }
}
