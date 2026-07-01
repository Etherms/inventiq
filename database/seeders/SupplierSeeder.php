<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name'=>'TechSource Inc.','contact_person'=>'John Reyes','phone'=>'09171234567','email'=>'sales@techsource.com','address'=>'Quezon City'],
            ['name'=>'Office Depot PH','contact_person'=>'Maria Cruz','phone'=>'09181234567','email'=>'contact@officedepot.ph','address'=>'Makati City'],
            ['name'=>'Global IT Solutions','contact_person'=>'Mark Santos','phone'=>'09192345678','email'=>'support@globalit.com','address'=>'Pasig City'],
            ['name'=>'Prime Furniture','contact_person'=>'Anna Garcia','phone'=>'09201234567','email'=>'sales@primefurniture.com','address'=>'Taguig City'],
            ['name'=>'Metro Packaging','contact_person'=>'Kevin Lim','phone'=>'09211234567','email'=>'orders@metropackaging.com','address'=>'Manila'],
            ['name'=>'PC Express Supply','contact_person'=>'Richard Ong','phone'=>'09221234567','email'=>'sales@pcexpress.ph','address'=>'Pasay City'],
            ['name'=>'Digital World Trading','contact_person'=>'Grace Tan','phone'=>'09231234567','email'=>'contact@digitalworld.ph','address'=>'Quezon City'],
            ['name'=>'Asia Office Hub','contact_person'=>'Louie Ramos','phone'=>'09241234567','email'=>'sales@officehub.ph','address'=>'Mandaluyong'],
            ['name'=>'CleanPro Distributors','contact_person'=>'Shane Flores','phone'=>'09251234567','email'=>'info@cleanpro.com','address'=>'Caloocan'],
            ['name'=>'Kitchen Central','contact_person'=>'Nicole Bautista','phone'=>'09261234567','email'=>'orders@kitchencentral.ph','address'=>'Parañaque'],
            ['name'=>'NetCore Systems','contact_person'=>'Albert Sy','phone'=>'09271234567','email'=>'sales@netcore.com','address'=>'Pasig'],
            ['name'=>'PowerTech Electrical','contact_person'=>'Brian Uy','phone'=>'09281234567','email'=>'support@powertech.com','address'=>'Makati'],
            ['name'=>'SafeGuard Supplies','contact_person'=>'Karen Dizon','phone'=>'09291234567','email'=>'sales@safeguard.com','address'=>'Taguig'],
            ['name'=>'Vision Electronics','contact_person'=>'Patrick Lee','phone'=>'09301234567','email'=>'contact@visionelec.com','address'=>'Manila'],
            ['name'=>'Bright Lighting Co.','contact_person'=>'Jennifer Co','phone'=>'09311234567','email'=>'sales@brightlight.com','address'=>'Las Piñas'],
            ['name'=>'CableLink PH','contact_person'=>'Jerome Cruz','phone'=>'09321234567','email'=>'orders@cablelink.com','address'=>'Pasig'],
            ['name'=>'Storage Plus','contact_person'=>'Ella Mendoza','phone'=>'09331234567','email'=>'support@storageplus.ph','address'=>'Quezon City'],
            ['name'=>'MobileHub Distribution','contact_person'=>'Victor Lim','phone'=>'09341234567','email'=>'sales@mobilehub.ph','address'=>'Muntinlupa'],
            ['name'=>'Office Essentials Co.','contact_person'=>'Camille Santos','phone'=>'09351234567','email'=>'hello@officeessentials.ph','address'=>'Marikina'],
            ['name'=>'SupplyMax Trading','contact_person'=>'Joshua Reyes','phone'=>'09361234567','email'=>'sales@supplymax.ph','address'=>'Valenzuela'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}