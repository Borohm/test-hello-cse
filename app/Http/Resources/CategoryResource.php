<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "CategoryResource",
    type: "object",
    title: "Category Resource",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Category Name"),
        new OA\Property(property: "picture", type: "url", example: "http://localhost/storage/category.jpg"),
        new OA\Property(property: "status", type: "string", enum: ["active", "disabled", "archived"], example: "active"),
        new OA\Property(property: "number_of_online_products", type: "integer", example: 5)
    ]
)]
class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'picture' => $this->picture ? asset('storage/' . $this->picture) : null,
            'status' => $this->status->label(),
            'number_of_online_products' => $this->products->where('status', 'active')->count()
        ];
    }
}
