<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class QuickSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        DB::table('users')->insertOrIgnore([
            'name' => 'E2E Tester',
            'email' => 'e2e_tester@example.com',
            'password' => Hash::make('secret123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Inventory
        DB::table('inventories')->insertOrIgnore([
            'blood_group' => 'A+',
            'units' => 10,
            'expiry_date' => now()->addDays(30),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Blood request
        DB::table('blood_requests')->insertOrIgnore([
            'hospital_name' => 'City Hospital',
            'blood_group' => 'B+',
            'units' => 5,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Appointment
        DB::table('appointments')->insertOrIgnore([
            'donor_name' => 'John Donor',
            'blood_group' => 'O-',
            'date' => now()->addDays(3)->toDateString(),
            'time' => '10:00',
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
