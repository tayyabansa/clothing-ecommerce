<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Classic White T-Shirt',
                'description' => 'A comfortable and versatile white t-shirt made from 100% cotton. Perfect for everyday wear.',
                'price' => 19.99,
                'image_url' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
                'category' => 'T-Shirts'
            ],
            [
                'name' => 'Slim Fit Jeans',
                'description' => 'Modern slim fit jeans with a comfortable stretch. Perfect for casual and semi-formal occasions.',
                'price' => 49.99,
                'image_url' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
                'category' => 'Jeans'
            ],
            [
                'name' => 'Casual Hoodie',
                'description' => 'A warm and cozy hoodie perfect for chilly days. Features a kangaroo pocket and adjustable hood.',
                'price' => 39.99,
                'image_url' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
                'category' => 'Hoodies'
            ],
            [
                'name' => 'Formal Dress Shirt',
                'description' => 'A crisp white dress shirt made from premium cotton. Perfect for formal occasions and business meetings.',
                'price' => 59.99,
                'image_url' => 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
                'category' => 'Shirts'
            ],
            [
                'name' => 'Summer Shorts',
                'description' => 'Lightweight and breathable shorts perfect for summer days. Features multiple pockets and a comfortable fit.',
                'price' => 29.99,
                'image_url' => 'https://images.unsplash.com/photo-1565084888279-aca607ecce0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
                'category' => 'Shorts'
            ],
            [
                'name' => 'Winter Jacket',
                'description' => 'A warm and stylish winter jacket with water-resistant outer shell and cozy inner lining.',
                'price' => 89.99,
                'image_url' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
                'category' => 'Jackets'
            ],
            [
                'name' => 'Running Shoes',
                'description' => 'Lightweight and comfortable running shoes with excellent cushioning and support.',
                'price' => 79.99,
                'image_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
                'category' => 'Shoes'
            ],
            [
                'name' => 'Leather Belt',
                'description' => 'Classic leather belt with a simple buckle. Perfect for both casual and formal wear.',
                'price' => 24.99,
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60',
                'category' => 'Accessories'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
