<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Student;
use Illuminate\Database\Seeder;

class CourseRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();
        $courses = Course::all();

        if ($students->isEmpty() || $courses->isEmpty()) {
            return;
        }

        // Distinct registration matrix to ensure realistic distribution
        // and idempotency without duplicate key violations
        foreach ($students as $index => $student) {
            // Enroll each student into 2 to 3 distinct courses
            $enrolledCourses = $courses->slice($index % 3, 3);

            foreach ($enrolledCourses as $course) {
                CourseRegistration::firstOrCreate(
                    [
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                    ],
                    [
                        'academic_year' => '2026/2027',
                        'semester' => 'Semester I',
                        'status' => 'registered',
                        'registered_at' => now()->subDays(rand(1, 14)),
                    ]
                );
            }
        }
    }
}

