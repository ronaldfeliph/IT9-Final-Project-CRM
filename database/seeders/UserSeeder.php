<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'              => 'Admin User',
                'email'             => 'admin@gmail.com',
                'password'          => Hash::make('admin123'),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ],

            [
                'name'              => 'Manager',
                'email'             => 'manager@gmail.com',
                'password'          => Hash::make('manager123'),
                'role'              => 'manager',
                'email_verified_at' => now(),
            ],

            [
                'name'              => 'Sales Staff',
                'email'             => 'salesstaff@gmail.com',
                'password'          => Hash::make('salesstaff123'),
                'role'              => 'sales_staff',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
 
        $this->command->info('Users seeded successfully.');
        $this->command->table(
            ['Name', 'Email', 'Role', 'Password'],
            collect($users)->map(fn ($u) => [
                $u['name'],
                $u['email'],
                $u['role'],
                'password',
            ])->toArray()
        );
    }
}
