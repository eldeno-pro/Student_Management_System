<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultPassword = Hash::make('password123');

        // 1. Administrator Account
        $admin = User::firstOrCreate(
            ['email' => 'admin@mubs.ac.ug'],
            [
                'name' => 'System Administrator',
                'password' => $defaultPassword,
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles(['admin']);

        // 2. Lecturer Accounts
        $lecturers = [
            [
                'name' => 'Bashir Mutebi',
                'email' => 'bmutebi@mubs.ac.ug',
            ],
            [
                'name' => 'Joy Tiko',
                'email' => 'jtiko@mubs.ac.ug',
            ],
            [
                'name' => 'Moshin Gyagenda',
                'email' => 'mgyagenda@mubs.ac.ug',
            ],
        ];

        foreach ($lecturers as $lecturerData) {
            $lecturer = User::firstOrCreate(
                ['email' => $lecturerData['email']],
                [
                    'name' => $lecturerData['name'],
                    'password' => $defaultPassword,
                    'email_verified_at' => now(),
                ]
            );
            $lecturer->syncRoles(['lecturer']);
        }

        // 3. Student Accounts
        $students = [
            [
                'name' => 'Denis Wawomola',
                'email' => '2400711902@mubs.ac.ug',
            ],
            [
                'name' => 'Namwase Whitney',
                'email' => 'wnamwase@mubs.ac.ug',
            ],
            [
                'name' => 'Muganga Anthony',
                'email' => 'amuganga@mubs.ac.ug',
            ],
            [
                'name' => 'Nyaika Keith',
                'email' => 'knyaika@mubs.ac.ug',
            ],
            [
                'name' => 'Atuhaire Patience',
                'email' => 'patuhaire@mubs.ac.ug',
            ],
            [
                'name' => 'Kato Samuel',
                'email' => 'skato@mubs.ac.ug',
            ],
        ];

        foreach ($students as $studentData) {
            $studentUser = User::firstOrCreate(
                ['email' => $studentData['email']],
                [
                    'name' => $studentData['name'],
                    'password' => $defaultPassword,
                    'email_verified_at' => now(),
                ]
            );
            $studentUser->syncRoles(['student']);
        }
    }
}

