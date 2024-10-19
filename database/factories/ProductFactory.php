<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'id' => Product::generateAlphanumericId(),
            'name' => $this->faker->word(), // Generates a random word
            'category' => $this->faker->word(), // Generates a random word for the category
            'descr' => $this->faker->paragraph(5), // Generates a paragraph with 5 sentences
            'image' => $this->faker->imageUrl(640, 480, 'posts', true), // Generates a fake image URL
            'rating' => $this->faker->numberBetween(1, 5), // Generates a random number between 1 and 5
            'brand' => $this->faker->company(), // Generates a random company name
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
    }
}
