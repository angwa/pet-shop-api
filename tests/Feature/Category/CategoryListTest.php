<?php

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryListTest extends TestCase
{
    /**
     * User can see list of categories
     * @return void
     */
    public function testUserCanViewCategories()
    {
        $response = $this->getJson('/api/v1/categories');

        $response->assertStatus(200);
        $this->assertIsObject($response);
    }
}
