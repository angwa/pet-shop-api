<?php

namespace Tests\Feature\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\IsActiveAdmin;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use WithFaker, IsActiveAdmin;

    /**
     * Admn cannot create product without login
     *
     * @return void
     */

    public function testAdminCanCreateProductWithoutLogin()
    {
        $response =  $this->postJson(
            '/api/v1/product/create',
            [
                'category_uuid' => Category::factory()->create()->uuid,
                'title' => $this->faker->sentence(2),
                'price' => $this->faker->randomFloat(2, 0, 10000),
                'description' => $this->faker->paragraph(3),
                'metadata' => json_encode([
                    "brand" => Brand::factory()->create()->uuid,
                    "image" => File::factory()->create()->uuid
                ])
            ],

        );

        $response->assertStatus(401);
    }

    /** 
     * Admin can create product
     * 
     * @return void
     */
    public function testAdminCanCreateProduct()
    {
        $response =  $this->postJson(
            '/api/v1/product/create',
            [
                'category_uuid' => Category::factory()->create()->uuid,
                'title' => $this->faker->sentence(2),
                'price' => $this->faker->randomFloat(2, 0, 10000),
                'description' => $this->faker->paragraph(3),
                'metadata' => json_encode([
                    "brand" => Brand::factory()->create()->uuid,
                    "image" => File::factory()->create()->uuid
                ])
            ],
            $this->activeAdmin(),

        );

        $response->assertStatus(201);
        $this->assertIsObject($response);
    }
}
