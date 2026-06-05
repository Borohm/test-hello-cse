<?php

namespace App\Http\Requests;

use App\Enums\CategoryStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'picture' => ['sometimes', 'image', 'max:2048'],
            'status' => ['sometimes', new Enum(CategoryStatus::class)]
        ];
    }
}
