<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Tests\TestCase;

class ViewProductSingleTest extends TestCase
{
    /**
     * Users can be able to view a single product
     *
     * @return void
     */
    public function testUserCanViewAProduct()
    {
        $product = Product::factory()->create()->uuid;

        $response = $this->getJson('/api/v1/product/' . $product);

        $response->assertStatus(200);
        $this->assertIsObject($response);
    }
}
