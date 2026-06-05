<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_can_get_products(): void
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                ->assertJsonCount(3, 'data');
    }

    public function test_can_create_product(): void
    {
        $category = Category::factory()->create();

        $response = $this->postJson('/api/product', [
            'name' => 'Test product',
            'price' => 10,
            'status' => 'draft',
            'category_id' => $category->id
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'name' => 'Test product',
            'price' => 10,
            'status' => 'draft',
            'category_id' => $category->id
        ]);
    }

    public function test_can_get_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/product/{$product->id}");

        $response->assertStatus(200)
                ->assertJsonPath('data.id', $product->id)
                ->assertJsonPath('data.name', $product->name);
    }

    public function test_can_update_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->putJson("/api/product/{$product->id}", [
            'name' => 'Updated Product',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
        ]);
    }

    public function test_can_delete_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/product/{$product->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
