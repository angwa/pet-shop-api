<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->times(50)->create();

        $user = User::where('email', 'admin@buckhill.co.uk')->first();

        if ((!$user) || $user->is_admin === 0) {
            User::create([
                'uuid' => Str::orderedUuid(),
                'first_name' => 'Buckhill',
                'last_name' => 'Admin',
                'is_admin' => 1,
                'email' => 'admin@buckhill.co.uk',
                'email_verified_at' => now(),
                'password' => '$2y$10$.1i.kOtcsK4wKEwWgbISc.BmkDFzaF.cmtRQt0y2GLdRwGlLXua3S', // admin
                'address' => 'Lagos, Nigeria',
                'phone_number' => '+23472322222',
                'is_marketing' => '0',
            ]);
        }
    }
}
