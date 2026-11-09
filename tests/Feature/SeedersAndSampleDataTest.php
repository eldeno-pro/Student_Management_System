<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SeedersAndSampleDataTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Question 2: Verify all seeding criteria and idempotency.
     */
    public function test_seeders_run_successfully_and_populate_expected_records(): void
    {
        // 1. Run seeder
        $this->seed(DatabaseSeeder::class);

        // a) Seed at least five students and four courses (1 mark)
        $this->assertGreaterThanOrEqual(5, Student::count());
        $this->assertGreaterThanOrEqual(4, Course::count());

        // b) Create sample user accounts and assign roles (1 mark)
        $this->assertGreaterThanOrEqual(3, User::count());
        $admin = User::where('email', 'admin@mubs.ac.ug')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->hasRole('admin'));

        $lecturer = User::where('email', 'bmutebi@mubs.ac.ug')->first();
        $this->assertNotNull($lecturer);
        $this->assertTrue($lecturer->hasRole('lecturer'));

        $studentUser = User::where('email', '2400711902@mubs.ac.ug')->first();
        $this->assertNotNull($studentUser);
        $this->assertTrue($studentUser->hasRole('student'));

        // c) Seed course registrations (1 mark)
        $this->assertGreaterThan(0, CourseRegistration::count());

        // d) Ensure seeders run without creating unnecessary duplicate records (1 mark)
        $initialStudentCount = Student::count();
        $initialCourseCount = Course::count();
        $initialUserCount = User::count();
        $initialRegistrationCount = CourseRegistration::count();

        // Run seeder again
        $this->seed(DatabaseSeeder::class);

        $this->assertEquals($initialStudentCount, Student::count(), 'Student count should not increase on re-seed');
        $this->assertEquals($initialCourseCount, Course::count(), 'Course count should not increase on re-seed');
        $this->assertEquals($initialUserCount, User::count(), 'User count should not increase on re-seed');
        $this->assertEquals($initialRegistrationCount, CourseRegistration::count(), 'Registration count should not increase on re-seed');
    }
}

