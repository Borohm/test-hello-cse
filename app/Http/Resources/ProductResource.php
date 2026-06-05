<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ProductResource",
    type: "object",
    title: "Product Resource",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Product Name"),
        new OA\Property(property: "price", type: "number", format: "float", example: 19.99),
        new OA\Property(property: "picture", type: "url", example: "http://localhost/storage/product.jpg"),
        new OA\Property(property: "status", type: "string", enum: ["active", "draft", "disabled"], example: "active"),
        new OA\Property(
            property: "category",
            ref: "#/components/schemas/CategoryResource"
        )
    ]
)]
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'picture' => $this->picture ? asset('storage/' . $this->picture) : null,
            'status' => $this->status->label(),
            'category' => CategoryResource::make($this->category)
        ];
    }
}
