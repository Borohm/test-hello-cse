<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    ){}

    #[
        OA\Get(
            path: "/api/categories",
            summary: "Get all categories",
            tags: ["Categories"],
            responses: [
                new OA\Response(
                    response: Response::HTTP_OK,
                    description: "Categories retrieved successfully",
                    content: new OA\JsonContent(ref: "#/components/schemas/CategoryResource")
                )
            ]
        )
    ]
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::all());
    }

    #[
        OA\Post(
            path: "/api/category",
            summary: "Create a new category",
            tags: ["Categories"],
            requestBody: new OA\RequestBody(
                required: true,
                content: new OA\MediaType(
                    mediaType: "multipart/form-data",
                    schema: new OA\Schema(
                        required: ["name"],
                        properties: [
                            new OA\Property(property: "name", type: "string", example: "New Category"),
                            new OA\Property(property: "status", type: "string", enum: ["active", "disabled", "archived"], example: "active"),
                            new OA\Property(property: "picture", type: "string", format: "binary")
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: Response::HTTP_CREATED,
                    description: "Category created successfully",
                    content: new OA\JsonContent(ref: "#/components/schemas/CategoryResource")
                ),
                new OA\Response(
                    response: Response::HTTP_UNPROCESSABLE_ENTITY,
                    description: "Validation failed"
                )
            ]
        )
    ]
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        return $this->categoryService->store($request->validated(), $request->file('picture'));
    }

    #[
        OA\Get(
            path: "/api/category/{id}",
            summary: "Get a category by ID",
            tags: ["Categories"],
            parameters: [
                new OA\Parameter(
                    name: "id",
                    in: "path",
                    description: "Category ID",
                    required: true,
                    schema: new OA\Schema(type: "string")
                )
            ],
            responses: [
                new OA\Response(
                    response: Response::HTTP_OK,
                    description: "Category retrieved successfully",
                    content: new OA\JsonContent(ref: "#/components/schemas/CategoryResource")
                ),
                new OA\Response(
                    response: Response::HTTP_NOT_FOUND,
                    description: "Category not found"
                 )
            ]
        )
    ]
    public function show(string $id): CategoryResource
    {
        return new CategoryResource(Category::findOrFail($id));
    }

    #[
        OA\Put(
            path: "/api/category/{id}",
            summary: "Update a category",
            tags: ["Categories"],
            parameters: [
                new OA\Parameter(
                    name: "id",
                    in: "path",
                    description: "Category ID",
                    required: true,
                    schema: new OA\Schema(type: "string")
                )
            ],
            requestBody: new OA\RequestBody(
                required: true,
                content: new OA\MediaType(
                    mediaType: "multipart/form-data",
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: "name", type: "string", example: "Updated Category"),
                            new OA\Property(property: "status", type: "string", enum: ["active", "disabled", "archived"], example: "active"),
                            new OA\Property(property: "picture", type: "string", format: "binary")
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: Response::HTTP_OK,
                    description: "Category updated successfully",
                    content: new OA\JsonContent(ref: "#/components/schemas/CategoryResource")
                ),
                new OA\Response(
                    response: Response::HTTP_NOT_FOUND,
                    description: "Category not found"
                ),
                new OA\Response(
                    response: Response::HTTP_UNPROCESSABLE_ENTITY,
                    description: "Validation failed"
                )
            ]
        )
    ]
    public function update(UpdateCategoryRequest $request, string $id): CategoryResource
    {
        return $this->categoryService->update($request->validated(), $request->file('picture'), $id);
    }

    #[
        OA\Delete(
            path: "/api/category/{id}",
            summary: "Delete a category",
            tags: ["Categories"],
            parameters: [
                new OA\Parameter(
                    name: "id",
                    in: "path",
                    description: "Category ID",
                    required: true,
                    schema: new OA\Schema(type: "string")
                )
            ],
            responses: [
                new OA\Response(
                    response: Response::HTTP_OK,
                    description: "Category deleted successfully"
                ),
                new OA\Response(
                    response: Response::HTTP_NOT_FOUND,
                    description: "Category not found"
                )
            ]
        )
    ]
    public function destroy(string $id): void
    {
        $this->categoryService->destroy($id);
    }
}
