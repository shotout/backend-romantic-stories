<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\Story::factory(10)->create([
            "category_id" => 1,
            "title" => "Relationship",
            "content" => "<p>Story About Relationship</p>",
            "created_at" => now(),
        ]);

        \App\Models\Story::factory(10)->create([
            "category_id" => 2,
            "title" => "I Miss You",
            "content" => "<p>Story About I Miss You</p>",
            "created_at" => now(),
        ]);

        \App\Models\Story::factory(10)->create([
            "category_id" => 3,
            "title" => "Dirty Mind",
            "content" => "<p>Story About Dirty Mind</p>",
            "created_at" => now(),
        ]);
    }
}
