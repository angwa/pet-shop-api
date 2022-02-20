<?php

namespace Database\Seeders;

use App\Models\JwtToken;
use Illuminate\Database\Seeder;

class JwtTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JwtToken::factory()->times(50)->create();
    }
}
