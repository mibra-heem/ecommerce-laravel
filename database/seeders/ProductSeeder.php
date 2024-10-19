<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Models\Category; // Make sure to include the Category model

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Assuming you have categories already created, let's use them
        $categories = Category::all();

        for ($i = 1; $i <= 30; $i++) {
            Product::create([
                'name' => 'Product ' . $i,
                // Assign a random category ID
                'category_id' => $categories->random()->id, // Randomly select an existing category ID
                'image' => 'https://via.placeholder.com/640x480.png?text=Product+' . $i,
                'descr' => 'Description for Product ' . $i,
                'rating' => rand(1, 5),
                'brand' => 'Brand ' . $i,
            ]);
        }
    }
}
