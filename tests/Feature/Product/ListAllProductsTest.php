<?php

namespace Tests\Feature\Product;

use Tests\TestCase;

class ListAllProductsTest extends TestCase
{
    /** 
     * All products can be listed
     * 
     * @return void
     */
    public function testUserCanRetrieveAllProduct()
    {
        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);
        $this->assertIsObject($response);
    }
}
