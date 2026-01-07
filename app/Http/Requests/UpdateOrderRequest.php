<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $order = $this->route('order');
        return $order && $order->user_id === auth()->user()->id && $order->status !== 'pending';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pickup_time' => 'sometimes|date_format:Y-m-d H:i',
            'services' => 'sometimes|array|min:1',
            'services.*.id' => 'sometimes|exists:services,id',
            'services.*.qty' => 'sometimes|integer|min:1',
        ];
    }
}
