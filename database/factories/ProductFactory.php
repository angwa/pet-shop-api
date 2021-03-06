<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_uuid' => Category::all()->random()->uuid,
            'uuid' => Str::orderedUuid(),
            'title' => $this->faker->sentence(2),
            'price' => $this->faker->randomFloat(2, 0, 10000),
            'description' => $this->faker->paragraph(3),
            'metadata' => json_encode([
                "brand" => Brand::all()->random()->uuid,
                "image" => File::factory()->create()->uuid
            ])
        ];
    }
}
