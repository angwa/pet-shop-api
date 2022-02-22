<?php

namespace Tests\Feature\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\IsActiveAdmin;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use WithFaker, IsActiveAdmin;

    private $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create()->uuid;
    }

    /** 
     * Admin not update product if not loggedin
     * 
     * 
     * @return void
     */
    public function testUserCannnotUpdateProfileWithoutLogin()
    {
        $response =  $this->putJson(
            '/api/v1/product/' . $this->product,
            [
                'category_uuid' => Category::factory()->create()->uuid,
                'title' => $this->faker->sentence(2),
                'price' => $this->faker->randomFloat(2, 0, 10000),
                'description' => $this->faker->paragraph(3),
                'metadata' => json_encode([
                    "brand" => Brand::factory()->create()->uuid,
                    "image" => File::factory()->create()->uuid
                ]),
            ],
        );

        $response->assertStatus(401);
    }

    /** 
     * Admin can now update product  but product not found
     * 
     * @return void
     */
    public function testAdminCanUpdateProductButNotFound()
    {
        $response =  $this->putJson(
            '/api/v1/product/',
            [
                'category_uuid' => Category::factory()->create()->uuid,
                'title' => $this->faker->sentence(2),
                'price' => $this->faker->randomFloat(2, 0, 10000),
                'description' => $this->faker->paragraph(3),
                'metadata' => json_encode([
                    "brand" => Brand::factory()->create()->uuid,
                    "image" => File::factory()->create()->uuid
                ]),
            ],
            $this->activeAdmin()
        );

        $response->assertStatus(404);
    }

    /** 
     * Admin can now update product 
     * 
     * @return void
     */
    public function testAdminCanUpdateProduct()
    {
        $response =  $this->putJson(
            '/api/v1/product/' . $this->product,
            [
                'category_uuid' => Category::factory()->create()->uuid,
                'title' => $this->faker->sentence(2),
                'price' => $this->faker->randomFloat(2, 0, 10000),
                'description' => $this->faker->paragraph(3),
                'metadata' => json_encode([
                    "brand" => Brand::factory()->create()->uuid,
                    "image" => File::factory()->create()->uuid
                ]),
            ],
            $this->activeAdmin()
        );

        $response->assertStatus(200);
        $this->assertIsObject($response);
    }
}
