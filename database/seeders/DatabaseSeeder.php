<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'status' => true,
            ],
            [
                'name' => 'manager',
                'email' => 'manager@gmail.com',
                'password' => bcrypt('manager123'),
                'role' => 'manager',
                'status' => true,
            ],
            [
                'name' => 'staff',
                'email' => 'staff@gmail.com',
                'password' => bcrypt('staff123'),
                'role' => 'staff',
                'status' => true,
            ],
        ];

        foreach ( $data as $key => $value ) {
            User::create($value);
        }
    }
}
