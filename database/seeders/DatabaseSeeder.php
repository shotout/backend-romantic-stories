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
            "title_en" => "Relationship",
            "title_id" => "Hubungan",
            "content_en" => "<p>Story About Relationship</p>",
            "content_id" => "<p>Cerita Tentang Hubungan</p>",
            "created_at" => now(),
        ]);

        \App\Models\Story::factory(10)->create([
            "category_id" => 2,
            "title_en" => "I Miss You",
            "title_id" => "Aku Merindukan Mu",
            "content_en" => "<p>Story About I Miss You</p>",
            "content_id" => "<p>Cerita Tentang Aku Merindukan Mu</p>",
            "created_at" => now(),
        ]);

        \App\Models\Story::factory(10)->create([
            "category_id" => 3,
            "title_en" => "Dirty Mind",
            "title_id" => "Pikiran Kotor",
            "content_en" => "<p>Story About Dirty Mind</p>",
            "content_id" => "<p>Cerita Tentang Pikiran Kotor</p>",
            "created_at" => now(),
        ]);
    }
}
