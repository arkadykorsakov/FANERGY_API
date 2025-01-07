<?php

namespace App\Http\Requests\Billing;

use App\Enums\PaymentSystem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'external_card_id' => 'required|string',
            'last_four_digits' => 'required|string|min:4|max:4',
            'system' => ['required', Rule::enum(PaymentSystem::class)],
        ];
    }
}
