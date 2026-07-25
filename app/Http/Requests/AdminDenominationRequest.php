<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminDenominationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:255',
            'nominal' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
    }
}
