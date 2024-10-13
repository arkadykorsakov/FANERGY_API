<?php

namespace App\Http\Requests\Profile;

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
			'name' => 'required',
			'email' => ['required', 'email', Rule::unique('users')->ignore($this->user())],
			'current_password' => 'required|min:8',
			'password' => 'required|min:8',
			'nickname' => ['required', Rule::unique('users')->ignore($this->user())],
			'youtube_link' => 'nullable',
			'twitch_link' => 'nullable',
			'vk_link' => 'nullable',
			'inst_link' => 'nullable',
			'tg_link' => 'nullable',
			'description' => 'required',
		];
	}
}
