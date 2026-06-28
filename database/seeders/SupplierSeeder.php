<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'TechSource Inc.',
                'contact_person' => 'John Reyes',
                'phone' => '09171234567',
                'email' => 'sales@techsource.com',
                'address' => 'Quezon City',
            ],
            [
                'name' => 'Office Depot PH',
                'contact_person' => 'Maria Cruz',
                'phone' => '09181234567',
                'email' => 'contact@officedepot.ph',
                'address' => 'Makati City',
            ],
            [
                'name' => 'Global IT Solutions',
                'contact_person' => 'Mark Santos',
                'phone' => '09192345678',
                'email' => 'support@globalit.com',
                'address' => 'Pasig City',
            ],
            [
                'name' => 'Prime Furniture',
                'contact_person' => 'Anna Garcia',
                'phone' => '09201234567',
                'email' => 'sales@primefurniture.com',
                'address' => 'Taguig City',
            ],
            [
                'name' => 'Metro Packaging',
                'contact_person' => 'Kevin Lim',
                'phone' => '09211234567',
                'email' => 'orders@metropackaging.com',
                'address' => 'Manila',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}