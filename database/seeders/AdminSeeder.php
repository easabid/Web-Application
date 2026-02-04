<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'type' => config('findtutors.user_types.SUPER_ADMIN'),
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@findtutors.com',
            'password' => Hash::make('Admin@123'),
            'mobile' => '01700000000',
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
            'gender' => 'Male',
            'date_of_birth' => '1990-01-01',
            'division' => 'Dhaka',
            'district' => 'Dhaka',
            'area' => 'Dhanmondi',
            'address' => 'Dhanmondi, Dhaka',
            'bio' => 'System Administrator',
            'completed_at' => now(),
            'approved_at' => now(),
            'is_active' => true,
            'is_suspended' => false,
        ]);

        $this->command->info('Super Admin created successfully!');
        $this->command->info('Email: admin@findtutors.com');
        $this->command->info('Password: Admin@123');
    }
}
