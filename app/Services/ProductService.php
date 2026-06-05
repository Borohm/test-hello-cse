<?php

namespace App\Services;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Services\PictureService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function __construct(
        private PictureService $pictureService
    ){}

    public function index(string|array|null $categoryId): AnonymousResourceCollection
    {
        $query = Product::query();
        error_log($categoryId);
        if (is_array($categoryId)) {
            $query->whereIn('category_id', $categoryId);
        } else if (null !== $categoryId) {
            $query->where('category_id', $categoryId);
        }

        return ProductResource::collection($query->get());
    }

    public function store(array $data, ?UploadedFile $picture): ProductResource
    {
        if ($picture) {
            $data['picture'] = $this->pictureService->uploadPicture($picture, 'products');
        }

        $product = Product::create($data);

        return new ProductResource($product);
    }

    public function update(array $data, ?UploadedFile $picture, string $id): ProductResource
    {
        $product = Product::findOrFail($id);
        
        if ($picture) {
            $data['picture'] = $this->pictureService->uploadPicture($picture, 'products');
            Storage::disk('public')->delete($product->picture);
        }

        $product->update($data);

        return new ProductResource($product);
    }

    public function destroy(string $id): void
    {
        $product = Product::findOrFail($id);
        Storage::disk('public')->delete($product->picture);
        $product->delete();
    }
}