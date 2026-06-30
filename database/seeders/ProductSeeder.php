<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'category_id' => 1,
                'supplier_id' => 1,
                'sku' => 'ELEC-0001',
                'name' => 'Logitech Wireless Mouse',
                'description' => 'Wireless ergonomic mouse',
                'cost_price' => 650,
                'selling_price' => 999,
                'stock' => 50,
                'reorder_level' => 10,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'supplier_id' => 2,
                'sku' => 'ELEC-0002',
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB mechanical gaming keyboard',
                'cost_price' => 1800,
                'selling_price' => 2499,
                'stock' => 30,
                'reorder_level' => 5,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'supplier_id' => 3,
                'sku' => 'OFF-0001',
                'name' => 'A4 Bond Paper',
                'description' => '80 GSM Premium Bond Paper',
                'cost_price' => 150,
                'selling_price' => 220,
                'stock' => 200,
                'reorder_level' => 50,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'supplier_id' => 1,
                'sku' => 'CLEAN-0001',
                'name' => 'Disinfectant Spray',
                'description' => '500ml antibacterial disinfectant',
                'cost_price' => 120,
                'selling_price' => 180,
                'stock' => 75,
                'reorder_level' => 20,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4,
                'supplier_id' => 2,
                'sku' => 'PANTRY-0001',
                'name' => 'Instant Coffee',
                'description' => '100-stick coffee pack',
                'cost_price' => 320,
                'selling_price' => 450,
                'stock' => 40,
                'reorder_level' => 10,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}