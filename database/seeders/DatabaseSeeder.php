<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Insert a Super Admin user
        DB::table('admin_users')->insert([
            'username' => 'superadmin',
            'password' => Hash::make('1234'), // Replace 'password' with a secure password
            'name' => 'Super Admin',
            'role' => 'super_admin',
            'company_id' => null, // Super Admin does not belong to a specific company
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}