<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'picture',
        'status',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted(): void
    {
        static::creating(function ($product) {
            $product->status = $product->status ?? ProductStatus::DRAFT;
        });
    }

    protected function casts(): array
    {
        return [
            'status' => ProductStatus::class,
        ];
    }
}
