<?php

namespace Database\Seeders;

use App\Models\ClassLevel;
use Illuminate\Database\Seeder;

class ClassLevelSeeder extends Seeder
{
    public function run(): void
    {
        $classLevels = [
            // Primary/School Level
            ['name' => 'Class 1', 'slug' => 'class-1', 'category' => 'School', 'display_order' => 1],
            ['name' => 'Class 2', 'slug' => 'class-2', 'category' => 'School', 'display_order' => 2],
            ['name' => 'Class 3', 'slug' => 'class-3', 'category' => 'School', 'display_order' => 3],
            ['name' => 'Class 4', 'slug' => 'class-4', 'category' => 'School', 'display_order' => 4],
            ['name' => 'Class 5', 'slug' => 'class-5', 'category' => 'School', 'display_order' => 5],
            
            // Junior Level
            ['name' => 'Class 6', 'slug' => 'class-6', 'category' => 'School', 'display_order' => 6],
            ['name' => 'Class 7', 'slug' => 'class-7', 'category' => 'School', 'display_order' => 7],
            ['name' => 'Class 8', 'slug' => 'class-8', 'category' => 'School', 'display_order' => 8],
            
            // Secondary Level
            ['name' => 'Class 9', 'slug' => 'class-9', 'category' => 'School', 'display_order' => 9],
            ['name' => 'Class 10', 'slug' => 'class-10', 'category' => 'School', 'display_order' => 10],
            
            // Board Exams
            ['name' => 'SSC', 'slug' => 'ssc', 'category' => 'Board', 'display_order' => 11],
            ['name' => 'HSC', 'slug' => 'hsc', 'category' => 'Board', 'display_order' => 12],
            ['name' => 'Dakhil', 'slug' => 'dakhil', 'category' => 'Board', 'display_order' => 13],
            ['name' => 'Alim', 'slug' => 'alim', 'category' => 'Board', 'display_order' => 14],
            
            // English Medium
            ['name' => 'O Level', 'slug' => 'o-level', 'category' => 'English Medium', 'display_order' => 15],
            ['name' => 'A Level', 'slug' => 'a-level', 'category' => 'English Medium', 'display_order' => 16],
            ['name' => 'IGCSE', 'slug' => 'igcse', 'category' => 'English Medium', 'display_order' => 17],
            
            // Higher Education
            ['name' => 'Honors/Degree', 'slug' => 'honors', 'category' => 'Higher', 'display_order' => 18],
            ['name' => 'Masters', 'slug' => 'masters', 'category' => 'Higher', 'display_order' => 19],
            ['name' => 'University Admission', 'slug' => 'university-admission', 'category' => 'Higher', 'display_order' => 20],
            ['name' => 'Medical Admission', 'slug' => 'medical-admission', 'category' => 'Higher', 'display_order' => 21],
            ['name' => 'Engineering Admission', 'slug' => 'engineering-admission', 'category' => 'Higher', 'display_order' => 22],
            ['name' => 'BCS Preparation', 'slug' => 'bcs-preparation', 'category' => 'Higher', 'display_order' => 23],
        ];

        foreach ($classLevels as $level) {
            ClassLevel::create($level);
        }

        $this->command->info('Class Levels seeded successfully!');
        $this->command->info('Total Levels: ' . count($classLevels));
        $this->command->info('School: ' . ClassLevel::where('category', 'School')->count());
        $this->command->info('Board: ' . ClassLevel::where('category', 'Board')->count());
        $this->command->info('English Medium: ' . ClassLevel::where('category', 'English Medium')->count());
        $this->command->info('Higher: ' . ClassLevel::where('category', 'Higher')->count());
    }
}
