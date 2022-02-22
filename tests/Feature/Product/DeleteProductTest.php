<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\IsActiveAdmin;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    use IsActiveAdmin, WithFaker;

    /** 
     * Admin product not found to be  deleted
     * 
     * @return void
     */
    public function testProductNotFound()
    {
        $response = $this->deleteJson('/api/v1/product');

        $response->assertStatus(404);
    }

    /**
     * A Admin can delete product
     * 
     * @return void
     */
    public function testAdminCanDeleteProduct()
    {
        $uuid = Product::factory()->create()->uuid;

        $response = $this->deleteJson('/api/v1/product/'.$uuid, [], $this->activeAdmin());

        $response->assertStatus(200);
    }
}
