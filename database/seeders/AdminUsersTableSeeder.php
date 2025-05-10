<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('admin_users')->insert([
            'username' => 'super_admin',
            'password' => Hash::make('1234'), // Replace 'password' with a secure password
            'name' => 'Super Admin',
            'role' => 'super_admin',
            'company_id' => 10, // Super Admin does not belong to a specific company
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
