<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and accessories.',
            ],
            [
                'name' => 'Office Supplies',
                'description' => 'Pens, paper, folders, and office essentials.',
            ],
            [
                'name' => 'Furniture',
                'description' => 'Office and home furniture.',
            ],
            [
                'name' => 'Cleaning Supplies',
                'description' => 'Cleaning equipment and consumables.',
            ],
            [
                'name' => 'Kitchen',
                'description' => 'Kitchen appliances and utensils.',
            ],
            [
                'name' => 'Networking',
                'description' => 'Routers, switches, and network accessories.',
            ],
            [
                'name' => 'Computer Parts',
                'description' => 'CPUs, RAM, SSDs, motherboards, and peripherals.',
            ],
            [
                'name' => 'Packaging',
                'description' => 'Boxes, tapes, labels, and packaging materials.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}