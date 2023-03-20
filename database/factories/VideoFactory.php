<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(2),
            'description' => fake()->sentence(10),
            'content' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Bq6IuZIJhuI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
        ];
    }

}
