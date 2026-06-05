<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ){}

    #[
        OA\Get(
            path: "/api/products",
            summary: "Get all products",
            tags: ["Products"],
            responses: [
                new OA\Response(
                    response: Response::HTTP_OK,
                    description: "Products retrieved successfully",
                    content: new OA\JsonContent(
                        type: "array",
                        items: new OA\Items(ref: "#/components/schemas/ProductResource")
                    )
                )
            ]
        )
    ]
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::all());
    }

    #[
        OA\Post(
            path: "/api/product",
            summary: "Create a new product",
            tags: ["Products"],
            requestBody: new OA\RequestBody(
                required: true,
                content: new OA\MediaType(
                    mediaType: "multipart/form-data",
                    schema: new OA\Schema(
                        required: ["name", "price", "category_id"],
                        properties: [
                            new OA\Property(property: "name", type: "string", example: "New Product"),
                            new OA\Property(property: "price", type: "number", format: "float", example: 19.99),
                            new OA\Property(property: "category_id", type: "integer", example: 1),
                            new OA\Property(property: "status", type: "string", enum: ["active", "draft", "disabled"], example: "active"),
                            new OA\Property(property: "picture", type: "string", format: "binary")
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: Response::HTTP_CREATED,
                    description: "Product created successfully",
                    content: new OA\JsonContent(ref: "#/components/schemas/ProductResource")
                ),
                new OA\Response(
                    response: Response::HTTP_UNPROCESSABLE_ENTITY,
                    description: "Validation failed"
                )
            ]
        )
    ]
    public function store(StoreProductRequest $request): ProductResource
    {
        return $this->productService->store($request->validated(), $request->file('picture'));
    }

    #[
        OA\Get(
            path: "/api/product/{id}",
            summary: "Get a product by ID",
            tags: ["Products"],
            parameters: [
                new OA\Parameter(
                    name: "id",
                    in: "path",
                    required: true,
                    description: "Product ID",
                    schema: new OA\Schema(type: "string")
                )
            ],
            responses: [
                new OA\Response(
                    response: Response::HTTP_OK,
                    description: "Product retrieved successfully",
                    content: new OA\JsonContent(ref: "#/components/schemas/ProductResource")
                ),
                new OA\Response(
                    response: Response::HTTP_NOT_FOUND,
                    description: "Product not found"
                )
            ]
        )
    ]
    public function show(string $id): ProductResource
    {
        return new ProductResource(Product::findOrFail($id));
    }

    #[
        OA\Put(
            path: "/api/product/{id}",
            summary: "Update a product",
            tags: ["Products"],
            parameters: [
                new OA\Parameter(
                    name: "id",
                    in: "path",
                    required: true,
                    description: "Product ID",
                    schema: new OA\Schema(type: "string")
                )
            ],
            requestBody: new OA\RequestBody(
                required: true,
                content: new OA\MediaType(
                    mediaType: "multipart/form-data",
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: "name", type: "string", example: "Updated Product"),
                            new OA\Property(property: "price", type: "number", format: "float", example: 29.99),
                            new OA\Property(property: "category_id", type: "integer", example: 1),
                            new OA\Property(property: "status", type: "string", enum: ["active", "draft", "disabled"], example: "active"),
                            new OA\Property(property: "picture", type: "string", format: "binary")
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: Response::HTTP_OK,
                    description: "Product updated successfully",
                    content: new OA\JsonContent(ref: "#/components/schemas/ProductResource")
                ),
                new OA\Response(
                    response: Response::HTTP_NOT_FOUND,
                    description: "Product not found"
                 ),
                new OA\Response(
                    response: Response::HTTP_UNPROCESSABLE_ENTITY,
                    description: "Validation failed"
                )
            ]
        )
    ]
    public function update(UpdateProductRequest $request, string $id): ProductResource
    {
        return $this->productService->update($request->validated(), $request->file('picture'), $id);
    }

    #[
        OA\Delete(
            path: "/api/product/{id}",
            summary: "Delete a product",
            tags: ["Products"],
            parameters: [
                new OA\Parameter(
                    name: "id",
                    in: "path",
                    required: true,
                    description: "Product ID",
                    schema: new OA\Schema(type: "string")
                )
            ],
            responses: [
                new OA\Response(
                    response: Response::HTTP_OK,
                    description: "Product deleted successfully"
                ),
                new OA\Response(
                    response: Response::HTTP_NOT_FOUND,
                    description: "Product not found"
                )
            ]
        )
    ]
    public function destroy(string $id): void
    {
        $this->productService->destroy($id);
    }
}
