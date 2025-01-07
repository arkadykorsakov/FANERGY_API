<?php

namespace App\Http\Requests\UserSubscription;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'subscription_level_id' => 'required|integer|exists:subscription_levels,id',
            'paid_subscription_start_date' => 'required|date',
            'paid_subscription_end_date' => 'required|date'
        ];
    }
}
