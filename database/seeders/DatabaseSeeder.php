<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            AreaSeeder::class,
            SubjectSeeder::class,
            ClassLevelSeeder::class,
            // DemoDataSeeder::class, // Uncomment for demo data
        ]);

        $this->command->info('✅ Database seeding completed successfully!');
    }
}
