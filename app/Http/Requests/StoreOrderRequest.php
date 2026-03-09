<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'services' => 'required|array|min:1',
            'services.*.id' => 'required|exists:services,id',
            'services.*.qty' => 'sometimes|integer|min:1',
            'pickup_time' => 'required|date|after_or_equal:now'
        ];
    }
}
