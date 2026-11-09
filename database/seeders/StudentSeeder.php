<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'email' => '2400711902@mubs.ac.ug',
                'student_number' => '2400711902',
                'registration_number' => '24/U/1902/EVE',
                'first_name' => 'Denis',
                'last_name' => 'Wawomola',
                'phone' => '+256701190200',
                'gender' => 'Male',
                'date_of_birth' => '2003-04-14',
                'program' => 'Bachelor of Business Computing',
                'year_of_study' => 3,
                'semester' => 1,
                'status' => 'active',
            ],
            [
                'email' => 'wnamwase@mubs.ac.ug',
                'student_number' => '2400712101',
                'registration_number' => '24/U/2101/EVE',
                'first_name' => 'Whitney',
                'last_name' => 'Namwase',
                'phone' => '+256702101001',
                'gender' => 'Female',
                'date_of_birth' => '2003-08-22',
                'program' => 'Bachelor of Business Computing',
                'year_of_study' => 3,
                'semester' => 1,
                'status' => 'active',
            ],
            [
                'email' => 'amuganga@mubs.ac.ug',
                'student_number' => '2400712102',
                'registration_number' => '24/U/2102/DAY',
                'first_name' => 'Anthony',
                'last_name' => 'Muganga',
                'phone' => '+256703102002',
                'gender' => 'Male',
                'date_of_birth' => '2002-11-05',
                'program' => 'Bachelor of Business Computing',
                'year_of_study' => 3,
                'semester' => 1,
                'status' => 'active',
            ],
            [
                'email' => 'knyaika@mubs.ac.ug',
                'student_number' => '2400712103',
                'registration_number' => '24/U/2103/EVE',
                'first_name' => 'Keith',
                'last_name' => 'Nyaika',
                'phone' => '+256704103003',
                'gender' => 'Male',
                'date_of_birth' => '2003-01-30',
                'program' => 'Bachelor of Business Computing',
                'year_of_study' => 3,
                'semester' => 1,
                'status' => 'active',
            ],
            [
                'email' => 'patuhaire@mubs.ac.ug',
                'student_number' => '2400712104',
                'registration_number' => '24/U/2104/DAY',
                'first_name' => 'Patience',
                'last_name' => 'Atuhaire',
                'phone' => '+256705104004',
                'gender' => 'Female',
                'date_of_birth' => '2004-03-18',
                'program' => 'Bachelor of Business Computing',
                'year_of_study' => 3,
                'semester' => 1,
                'status' => 'active',
            ],
            [
                'email' => 'skato@mubs.ac.ug',
                'student_number' => '2400712105',
                'registration_number' => '24/U/2105/EVE',
                'first_name' => 'Samuel',
                'last_name' => 'Kato',
                'phone' => '+256706105005',
                'gender' => 'Male',
                'date_of_birth' => '2003-06-12',
                'program' => 'Bachelor of Business Computing',
                'year_of_study' => 3,
                'semester' => 1,
                'status' => 'active',
            ],
        ];

        foreach ($students as $studentData) {
            $user = User::where('email', $studentData['email'])->first();

            Student::updateOrCreate(
                ['student_number' => $studentData['student_number']],
                array_merge($studentData, ['user_id' => $user?->id])
            );
        }
    }
}

