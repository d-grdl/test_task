<?php

namespace Database\Seeders;

use App\Models\Picture;
use App\Models\Tag;
use App\Models\Video;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Tag::factory(15)->create();
        Video::factory(50)->create();

        Video::all()->each(function ($video) {
            $video->tags()->attach(
                rand(1, 15)
            );
        });
    }
}
