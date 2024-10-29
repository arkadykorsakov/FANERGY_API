<?php

namespace App\Http\Requests\Post;

use App\Enums\Category;
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
            'title' => 'required',
            'description' => 'required',
            'category' => ['required', Rule::enum(Category::class)],
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
            'links' => 'nullable|array',
            'links.*' => 'url',
            'preview' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'files' => 'nullable|array|max:5',
            'files.*' => 'file|mimes:doc,docx,pdf|max:2048',
            'audios' => 'nullable|array|max:9',
            'audios.*' => 'file|mimes:audio/mpeg,mpga,mp3,wav,aac|max:10240',
            'video' => 'nullable|file|mimes:mp4,mov,ogg,avi,mpg|max:10240',
            'images' => 'nullable|array|max:9',
            'images.*' => 'file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'access_level_id'=>'nullable|integer|exists:access_levels,id',
        ];
    }
}
