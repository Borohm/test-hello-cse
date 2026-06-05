<?php

namespace App\Http\Requests;

use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'price' => ['required', 'decimal:0,2', 'min:0'],
            'picture' => ['sometimes', 'image', 'max:2048'],
            'status' => ['sometimes', new Enum(ProductStatus::class)],
            'category_id' => ['required', 'exists:categories,id']
        ];
    }
}
