<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'min:5', 'max:80'],
            'categorie_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string', 'min:10'],
            'prix' => ['required', 'numeric', 'min:0'],
            'stock' => ['nullable', 'numeric', 'min:0'],
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:5120'],
        ];
    }
}
