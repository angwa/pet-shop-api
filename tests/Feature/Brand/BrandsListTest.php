<?php

namespace Tests\Feature\Brand;

use Tests\TestCase;

class BrandsListTest extends TestCase
{
    public function testUserCanViewBrands()
    {
        $response = $this->getJson('/api/v1/brands');

        $response->assertStatus(200);
        $this->assertIsObject($response);
    }
}
