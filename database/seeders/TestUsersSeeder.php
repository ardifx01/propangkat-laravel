<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin ProPangkat',
            'email' => 'admin@propangkat.test',
            'username' => 'admin',
            'nip' => '198101012001121001',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Operator User
        User::create([
            'name' => 'Operator ProPangkat',
            'email' => 'operator@propangkat.test',
            'username' => 'operator',
            'nip' => '198101012001121002',
            'password' => Hash::make('password'),
            'role' => 'operator',
        ]);
        
        // Operator Sekolah User
        User::create([
            'name' => 'Operator Sekolah',
            'email' => 'operatorsekolah@propangkat.test',
            'username' => 'operatorsekolah',
            'nip' => '198101012001121003',
            'password' => Hash::make('password'),
            'role' => 'operator-sekolah',
        ]);

        // Pegawai User
        User::create([
            'name' => 'Pegawai ProPangkat',
            'email' => 'pegawai@propangkat.test',
            'username' => 'pegawai',
            'nip' => '198101012001121004',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
        ]);
    }
}
