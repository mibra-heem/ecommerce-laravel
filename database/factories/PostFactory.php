<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(5),
            'image' => $this->faker->imageUrl(640, 480, 'posts', true), // Generates a fake image URL
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
