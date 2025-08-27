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
            'nip' => '198001012001121001',
            'password' => bcrypt('admin123'),
        ]);

        // Create an operator user
        User::factory()->operator()->create([
            'name' => 'Operator',
            'email' => 'operator@propangkat.com',
            'username' => 'operator',
            'nip' => '198001012001121002',
            'password' => bcrypt('operator123'),
        ]);
        
        // Create an operator sekolah user
        User::factory()->operatorSekolah()->create([
            'name' => 'Operator Sekolah',
            'email' => 'opsekolah@propangkat.com',
            'username' => 'opsekolah',
            'nip' => '198001012001121003',
            'password' => bcrypt('opsekolah123'),
        ]);

        // Create a regular pegawai user
        User::factory()->pegawai()->create([
            'name' => 'Pegawai',
            'email' => 'pegawai@propangkat.com',
            'username' => 'pegawai',
            'nip' => '198901012020011001',
            'password' => bcrypt('pegawai123'),
        ]);
        
        // Create additional random users
        User::factory(10)->create();
    }
}
