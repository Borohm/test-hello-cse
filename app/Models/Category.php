<?php

namespace App\Models;

use App\Enums\CategoryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'picture',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected static function booted(): void
    {
        static::creating(function ($category) {
            $category->status = $category->status ?? CategoryStatus::DISABLED;
        });
    }

    protected function casts(): array
    {
        return [
            'status' => CategoryStatus::class,
        ];
    }
}
