<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Propaganistas\LaravelPhone\Rules\Phone;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'nickname' => 'required|unique:users,nickname',
            'youtube_link' => 'nullable',
            'twitch_link' => 'nullable',
            'vk_link' => 'nullable',
            'inst_link' => 'nullable',
            'tg_link' => 'nullable',
            'description' => 'required',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'phone' => ['required', new Phone()],
        ];
    }
}
