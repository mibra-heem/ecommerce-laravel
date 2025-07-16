<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Create parent categories first
        $electronics = Category::create([
            'name' => 'Electronics',
            'parent_id' => null,
            'icon_url' => 'https://picsum.photos/200/200?random=1',
            'description' => 'Explore the latest gadgets and devices.',
            'is_active' => true,
            'order' => 1,
        ]);

        $fashion = Category::create([
            'name' => 'Fashion',
            'parent_id' => null,
            'icon_url' => 'https://picsum.photos/200/200?random=2',
            'description' => 'Trendy clothing and accessories.',
            'is_active' => true,
            'order' => 2,
        ]);

        $homeKitchen = Category::create([
            'name' => 'Home & Kitchen',
            'parent_id' => null,
            'icon_url' => 'https://picsum.photos/200/200?random=3',
            'description' => 'Essentials for your home and kitchen.',
            'is_active' => true,
            'order' => 3,
        ]);

        // Create child categories using parent IDs
        Category::create([
            'name' => 'Smartphones',
            'parent_id' => $electronics->id,
            'icon_url' => 'https://picsum.photos/200/200?random=4',
            'description' => 'Top smartphones from leading brands.',
            'is_active' => true,
            'order' => 1,
        ]);

        Category::create([
            'name' => 'Laptops',
            'parent_id' => $electronics->id,
            'icon_url' => 'https://picsum.photos/200/200?random=5',
            'description' => 'High-performance laptops for work and play.',
            'is_active' => true,
            'order' => 3,
        ]);

        Category::create([
            'name' => 'Accessories',
            'parent_id' => $electronics->id,
            'icon_url' => 'https://picsum.photos/200/200?random=6',
            'description' => 'Essential electronic accessories.',
            'is_active' => true,
            'order' => 2,
        ]);

        $mensClothing = Category::create([
            'name' => 'Men’s Clothing',
            'parent_id' => $fashion->id,
            'icon_url' => 'https://picsum.photos/200/200?random=7',
            'description' => 'Stylish clothing for men.',
            'is_active' => true,
            'order' => 2,
        ]);

        $footwear = Category::create([
            'name' => 'Foot Wear',
            'parent_id' => $fashion->id,
            'icon_url' => 'https://picsum.photos/200/200?random=7',
            'description' => 'Stylish foot wear.',
            'is_active' => true,
            'order' => 2,
        ]);

        Category::create([
            'name' => 'Shirts',
            'parent_id' => $mensClothing->id,
            'icon_url' => 'https://picsum.photos/200/200?random=8',
            'description' => 'Casual and formal shirts.',
            'is_active' => true,
            'order' => 1,
        ]);

        Category::create([
            'name' => 'Jeans',
            'parent_id' => $mensClothing->id,
            'icon_url' => 'https://picsum.photos/200/200?random=9',
            'description' => 'Comfortable and trendy jeans.',
            'is_active' => true,
            'order' => 2,
        ]);

        Category::create([
            'name' => 'Women’s Clothing',
            'parent_id' => $fashion->id,
            'icon_url' => 'https://picsum.photos/200/200?random=10',
            'description' => 'Fashionable clothing for women.',
            'is_active' => true,
            'order' => 1,
        ]);
    }
}