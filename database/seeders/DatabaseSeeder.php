<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user
        User::factory()->admin()->create([
            'name' => 'Administrator',
            'email' => 'admin@propangkat.com',
            'username' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        // Create a verifikator user
        User::factory()->verifikator()->create([
            'name' => 'Verifikator',
            'email' => 'verifikator@propangkat.com',
            'username' => 'verifikator',
            'password' => bcrypt('verifikator123'),
        ]);

        // Create an operator user
        User::factory()->operator()->create([
            'name' => 'Operator',
            'email' => 'operator@propangkat.com',
            'username' => 'operator',
            'password' => bcrypt('operator123'),
        ]);

        // Create a regular pegawai user
        User::factory()->pegawai()->create([
            'name' => 'Pegawai',
            'email' => 'pegawai@propangkat.com',
            'username' => '198901012020011001',
            'password' => bcrypt('pegawai123'),
        ]);
        
        // Create additional random users
        User::factory(10)->create();
    }
}
