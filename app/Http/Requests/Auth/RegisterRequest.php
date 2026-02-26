<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'firstname' => ['required', 'string', 'min:2', 'max:255'],
            'lastname' => ['required', 'string', 'min:2', 'max:255'],
            'pseudo' => ['required', 'string', 'min:3', 'max:255', 'unique:users,pseudo'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)->letters()->mixedCase()->numbers()],
            'description' => ['nullable', 'string', 'max:160'],
            'avatar' => ['required', 'string', 'in:av1,av2,av3,av4,av5,av6'],
            'specialite' => ['nullable', 'string', 'in:uidesign,dev,illustration,motion,audio,formation,3D,mobile'],
            'plan' => ['required', 'string', 'in:createur,pro,gratuit'],
        ];
    }
}
