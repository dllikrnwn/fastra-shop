<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('game')?->id ?? 'null';

        return [
            'category_id' => 'required|exists:game_categories,id',
            'name' => 'required|string|max:255',
            'slug' => "nullable|string|max:255|unique:games,slug,{$id}",
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'guide_video' => 'nullable|mimetypes:video/mp4,video/webm,video/x-msvideo|max:51200',
            'description' => 'nullable|string|max:1000',
            'has_custom_amount' => 'boolean',
            'rate' => 'nullable|numeric|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
    }
}
