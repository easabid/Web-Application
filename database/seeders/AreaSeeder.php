<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        // 8 Divisions of Bangladesh
        $divisions = [
            ['name' => 'Dhaka', 'bn_name' => 'ঢাকা'],
            ['name' => 'Chittagong', 'bn_name' => 'চট্টগ্রাম'],
            ['name' => 'Rajshahi', 'bn_name' => 'রাজশাহী'],
            ['name' => 'Khulna', 'bn_name' => 'খুলনা'],
            ['name' => 'Sylhet', 'bn_name' => 'সিলেট'],
            ['name' => 'Barisal', 'bn_name' => 'বরিশাল'],
            ['name' => 'Rangpur', 'bn_name' => 'রংপুর'],
            ['name' => 'Mymensingh', 'bn_name' => 'ময়মনসিংহ'],
        ];

        foreach ($divisions as $division) {
            Area::create([
                'name' => $division['name'],
                'bn_name' => $division['bn_name'],
                'parent_id' => null,
                'level' => 'Division',
                'is_active' => true,
            ]);
        }

        // Districts and Areas for Dhaka Division
        $dhakaDivision = Area::where('name', 'Dhaka')->first();
        
        $dhakaDistricts = [
            'Dhaka' => [
                'Dhanmondi', 'Mirpur', 'Uttara', 'Gulshan', 'Banani', 'Mohammadpur',
                'Motijheel', 'Badda', 'Bashundhara', 'Rampura', 'Khilgaon', 'Mohakhali',
                'Tejgaon', 'Farmgate', 'Elephant Road', 'Old Dhaka', 'Azimpur', 'New Market'
            ],
            'Gazipur' => ['Tongi', 'Board Bazar', 'Joydebpur', 'Kaliakair', 'Sreepur'],
            'Narayanganj' => ['Narayanganj Sadar', 'Rupganj', 'Sonargaon', 'Bandar'],
            'Tangail' => ['Tangail Sadar', 'Kalihati', 'Mirzapur', 'Madhupur'],
            'Manikganj' => ['Manikganj Sadar', 'Singair', 'Saturia'],
        ];

        foreach ($dhakaDistricts as $districtName => $areas) {
            $district = Area::create([
                'name' => $districtName,
                'parent_id' => $dhakaDivision->id,
                'level' => 'District',
                'is_active' => true,
            ]);

            foreach ($areas as $areaName) {
                Area::create([
                    'name' => $areaName,
                    'parent_id' => $district->id,
                    'level' => 'Area',
                    'is_active' => true,
                ]);
            }
        }

        // Districts for Chittagong Division
        $chittagongDivision = Area::where('name', 'Chittagong')->first();
        
        $chittagongDistricts = [
            'Chittagong' => [
                'Agrabad', 'Panchlaish', 'Khulshi', 'Halishahar', 'Chawk Bazar',
                'Pahartali', 'Bayezid', 'Nasirabad', 'GEC', 'Chandgaon'
            ],
            'Coxs Bazar' => ['Coxs Bazar Sadar', 'Teknaf', 'Ramu', 'Ukhia'],
            'Comilla' => ['Comilla Sadar', 'Daudkandi', 'Brahmanpara'],
        ];

        foreach ($chittagongDistricts as $districtName => $areas) {
            $district = Area::create([
                'name' => $districtName,
                'parent_id' => $chittagongDivision->id,
                'level' => 'District',
                'is_active' => true,
            ]);

            foreach ($areas as $areaName) {
                Area::create([
                    'name' => $areaName,
                    'parent_id' => $district->id,
                    'level' => 'Area',
                    'is_active' => true,
                ]);
            }
        }

        // Districts for Sylhet Division
        $sylhetDivision = Area::where('name', 'Sylhet')->first();
        
        $sylhetDistricts = [
            'Sylhet' => ['Sylhet Sadar', 'Zindabazar', 'Ambarkhana', 'Mirer Maydan', 'Uposhohor'],
            'Moulvibazar' => ['Moulvibazar Sadar', 'Srimangal', 'Kulaura'],
        ];

        foreach ($sylhetDistricts as $districtName => $areas) {
            $district = Area::create([
                'name' => $districtName,
                'parent_id' => $sylhetDivision->id,
                'level' => 'District',
                'is_active' => true,
            ]);

            foreach ($areas as $areaName) {
                Area::create([
                    'name' => $areaName,
                    'parent_id' => $district->id,
                    'level' => 'Area',
                    'is_active' => true,
                ]);
            }
        }

        // Districts for Rajshahi Division
        $rajshahiDivision = Area::where('name', 'Rajshahi')->first();
        
        $rajshahiDistricts = [
            'Rajshahi' => ['Rajshahi Sadar', 'Boalia', 'Shaheb Bazar', 'Motihar', 'Kazla'],
            'Bogra' => ['Bogra Sadar', 'Sherpur', 'Shibganj'],
        ];

        foreach ($rajshahiDistricts as $districtName => $areas) {
            $district = Area::create([
                'name' => $districtName,
                'parent_id' => $rajshahiDivision->id,
                'level' => 'District',
                'is_active' => true,
            ]);

            foreach ($areas as $areaName) {
                Area::create([
                    'name' => $areaName,
                    'parent_id' => $district->id,
                    'level' => 'Area',
                    'is_active' => true,
                ]);
            }
        }

        $this->command->info('Areas seeded successfully!');
        $this->command->info('Total Divisions: 8');
        $this->command->info('Total Districts: ' . Area::where('level', 'District')->count());
        $this->command->info('Total Areas: ' . Area::where('level', 'Area')->count());
    }
}
