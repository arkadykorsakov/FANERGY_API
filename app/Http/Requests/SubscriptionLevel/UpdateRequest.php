<?php

namespace App\Http\Requests\SubscriptionLevel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
			'title' => 'required',
			'description' => 'required',
			'price_per_month' => 'required|numeric|between:0,99999999.99',
			'image' => 'file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'order' => [
                'required',
                'integer',
                'between:1,5',
                Rule::unique('subscription_levels')
                    ->ignore($this->route('subscriptionLevel')->id)
                    ->where('user_id', auth()->id())
            ],
		];
	}
}
