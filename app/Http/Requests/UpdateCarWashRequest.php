<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarWashRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $carWash = $this->route('carWash');
        if (!$carWash) {
            return false;
        }

        return $carWash->user_id === auth()->id();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->is_active === 'active' ? 1 : 0,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'is_active' => 'required|boolean',
            'new_images' => 'nullable|array|max:10',
            'new_images.*' => 'image|max:2048',
        ];
    }
}
