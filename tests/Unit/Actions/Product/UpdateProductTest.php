<?php

namespace Tests\Unit\Actions\Product;

use App\Actions\Product\UpdateProductAction;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    use WithFaker;

    private $newInstanceOfClass;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $productUuid =  Product::factory()->create();
        $this->newInstanceOfClass = new UpdateProductAction($this->request(), $productUuid);
    }

    /**
     * Execute method test for product update should return true
     *
     * @return void
     */
    public function testExecutMethodForProductOdateShouldReturnTrue()
    {
        $this->assertTrue($this->newInstanceOfClass->execute());
    }

    /**
     * @return ProductRequest
     */
    private function request(): ProductRequest
    {
        $request = new ProductRequest();

        $request->merge([
            'category_uuid' => Category::factory()->create()->uuid,
            'uuid' => Str::orderedUuid(),
            'title' => $this->faker->sentence(2),
            'price' => $this->faker->randomFloat(2, 0, 10000),
            'description' => $this->faker->paragraph(3),
            'metadata' => json_encode([
                "brand" => Brand::factory()->create()->uuid,
                "image" => File::factory()->create()->uuid
            ]),
        ]);

        return $request;
    }
}
