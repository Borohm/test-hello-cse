<?php

namespace App\Http\Requests;

use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'price' => ['sometimes', 'decimal:0,2', 'min:0'],
            'picture' => ['sometimes', 'image', 'max:2048'],
            'status' => ['sometimes', new Enum(ProductStatus::class)],
            'category_id' => ['sometimes', 'exists:categories,id']
        ];
    }
}
