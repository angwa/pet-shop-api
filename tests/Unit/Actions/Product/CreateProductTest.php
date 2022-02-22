<?php

namespace Tests\Unit\Actions\Product;

use App\Actions\Product\CreateProductAction;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use WithFaker;

    private $newInstanceOfClass;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->newInstanceOfClass = new CreateProductAction($this->request());
    }

    /**
     * Execute method test for product creation
     *
     * @return void
     */
    public function testExecuteForCreatingMethodShouldReturnObject()
    {
        $this->assertIsObject($this->newInstanceOfClass->execute());
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
