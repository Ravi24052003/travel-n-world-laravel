<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    { 

        $user = User::where("email", request()->input("email"))->first();

        if(!empty($user)){
            if($user->is_authorised){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return true;
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
            "email"=> ["required", "exists:users,email", "email"],
            "password"=> [
            "required",
            Password::min(8)
            ->letters()
            ->symbols()
            ]
        ];
    }

    
    public function messages(): array
{
    return [
        'email.required' => 'The email field is mandatory.',
        'email.email' => 'Please enter a valid email address.',
        'email.exists' => 'The provided email does not exist in our records.',
        'password.required' => 'The password field is mandatory.',
        'password.min' => 'The password must be at least 8 characters long.',
        'password.letters' => 'The password must contain at least one letter.',
        'password.symbols' => 'The password must contain at least one symbol.',
    ];
}

}
