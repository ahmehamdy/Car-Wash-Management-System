<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
        // return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->status === 'active' ? 1 : 0,
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
            'price' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer|min:1',
            'status' => 'required|boolean',
        ];
    }
}
