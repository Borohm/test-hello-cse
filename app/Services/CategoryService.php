<?php

namespace App\Services;

use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Services\PictureService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public function __construct(
        private PictureService $pictureService
    ){}

    public function store(array $data, ?UploadedFile $picture): CategoryResource
    {
        if ($picture) {
            $data['picture'] = $this->pictureService->uploadPicture($picture, 'categories');
        }

        $category = Category::create($data);

        return new CategoryResource($category);
    }

    public function update(array $data, ?UploadedFile $picture, string $id): CategoryResource
    {
        $category = Category::findOrFail($id);
        
        if ($picture) {
            $data['picture'] = $this->pictureService->uploadPicture($picture, 'categories');
            Storage::disk('public')->delete($category->picture);
        }

        $category->update($data);

        return new CategoryResource($category);
    }

    public function destroy(string $id): void
    {
        $category = Category::findOrFail($id);
        Storage::disk('public')->delete($category->picture);
        $category->delete();
    }
}