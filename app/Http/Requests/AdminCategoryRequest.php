<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('category')?->id ?? 'null';

        return [
            'name' => 'required|string|max:255',
            'slug' => "nullable|string|max:255|unique:game_categories,slug,{$id}",
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ];
    }
}
