<?php

namespace App\Http\Requests\Subscribe;

use Illuminate\Foundation\Http\FormRequest;

class UpgradeRequest extends FormRequest
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
			'months' => 'required|integer|between:1,18',
		];
	}
}
