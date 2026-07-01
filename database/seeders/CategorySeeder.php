<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and accessories.'],
            ['name' => 'Office Supplies', 'description' => 'Pens, paper, folders, and office essentials.'],
            ['name' => 'Furniture', 'description' => 'Office and home furniture.'],
            ['name' => 'Cleaning Supplies', 'description' => 'Cleaning equipment and consumables.'],
            ['name' => 'Kitchen', 'description' => 'Kitchen appliances and utensils.'],
            ['name' => 'Networking', 'description' => 'Routers, switches, and network accessories.'],
            ['name' => 'Computer Parts', 'description' => 'CPUs, RAM, SSDs, motherboards, and peripherals.'],
            ['name' => 'Packaging', 'description' => 'Boxes, tapes, labels, and packaging materials.'],
            ['name' => 'Storage', 'description' => 'Storage containers and organization products.'],
            ['name' => 'Security', 'description' => 'Security cameras and safety equipment.'],
            ['name' => 'Tools', 'description' => 'Hand tools and power tools.'],
            ['name' => 'Electrical', 'description' => 'Electrical supplies and accessories.'],
            ['name' => 'Appliances', 'description' => 'Small office and home appliances.'],
            ['name' => 'Printers', 'description' => 'Printers, scanners, and accessories.'],
            ['name' => 'Mobile Devices', 'description' => 'Smartphones and tablets.'],
            ['name' => 'Audio', 'description' => 'Speakers, headphones, and microphones.'],
            ['name' => 'Cables', 'description' => 'HDMI, USB, LAN, and power cables.'],
            ['name' => 'Lighting', 'description' => 'LED lights and lighting fixtures.'],
            ['name' => 'Health & Safety', 'description' => 'Safety kits and workplace protection.'],
            ['name' => 'Miscellaneous', 'description' => 'Other inventory items.'],
        ];
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}