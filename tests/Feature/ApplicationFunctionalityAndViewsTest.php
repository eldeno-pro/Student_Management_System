<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationFunctionalityAndViewsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Question 4a: Student CRUD operations.
     */
    public function test_admin_can_perform_student_crud(): void
    {
        $admin = User::where('email', 'admin@mubs.ac.ug')->first();

        // 1. Index
        $response = $this->actingAs($admin)->get(route('students.index'));
        $response->assertStatus(200);
        $response->assertSee('Student Records');

        // 2. Create / Store
        $newStudentData = [
            'first_name' => 'Alice',
            'last_name' => 'Nabirye',
            'student_number' => '2400799999',
            'registration_number' => '24/U/9999/EVE',
            'email' => 'anabirye@mubs.ac.ug',
            'program' => 'Bachelor of Business Computing',
            'year_of_study' => 3,
            'semester' => 1,
            'gender' => 'Female',
        ];

        $storeResponse = $this->actingAs($admin)->post(route('students.store'), $newStudentData);
        $storeResponse->assertRedirect(route('students.index'));
        $storeResponse->assertSessionHas('success');
        $this->assertDatabaseHas('students', ['student_number' => '2400799999']);

        // 3. Edit / Update
        $student = Student::where('student_number', '2400799999')->first();
        $updateResponse = $this->actingAs($admin)->put(route('students.update', $student), array_merge($newStudentData, [
            'phone' => '+256709999888',
        ]));
        $updateResponse->assertRedirect(route('students.show', $student));
        $updateResponse->assertSessionHas('success');
        $this->assertDatabaseHas('students', ['phone' => '+256709999888']);

        // 4. Delete
        $deleteResponse = $this->actingAs($admin)->delete(route('students.destroy', $student));
        $deleteResponse->assertRedirect(route('students.index'));
        $deleteResponse->assertSessionHas('success');
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    /**
     * Question 4b: Course CRUD operations.
     */
    public function test_admin_can_perform_course_crud(): void
    {
        $admin = User::where('email', 'admin@mubs.ac.ug')->first();
        $lecturer = User::where('email', 'bmutebi@mubs.ac.ug')->first();

        // 1. Store
        $courseData = [
            'code' => 'BUC3199',
            'title' => 'Emerging Trends in Business Computing',
            'credit_units' => 3,
            'year_of_study' => 3,
            'semester' => 1,
            'lecturer_id' => $lecturer->id,
            'description' => 'Artificial Intelligence and Agentic workflows.',
        ];

        $response = $this->actingAs($admin)->post(route('courses.store'), $courseData);
        $response->assertRedirect(route('courses.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('courses', ['code' => 'BUC3199']);

        // 2. Update
        $course = Course::where('code', 'BUC3199')->first();
        $updateResponse = $this->actingAs($admin)->put(route('courses.update', $course), array_merge($courseData, [
            'title' => 'Emerging Trends in AI and Computing',
        ]));
        $updateResponse->assertRedirect(route('courses.show', $course));
        $this->assertDatabaseHas('courses', ['title' => 'Emerging Trends in AI and Computing']);

        // 3. Delete
        $deleteResponse = $this->actingAs($admin)->delete(route('courses.destroy', $course));
        $deleteResponse->assertRedirect(route('courses.index'));
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    /**
     * Question 4c: Course registration with validation and duplicate prevention.
     */
    public function test_course_registration_and_duplicate_prevention(): void
    {
        $studentUser = User::where('email', '2400711902@mubs.ac.ug')->first();
        $student = $studentUser->student;

        // Pick an un-enrolled course
        $enrolledIds = $student->courses->pluck('id')->toArray();
        $courseToRegister = Course::whereNotIn('id', $enrolledIds)->first();

        // 1. Successful registration
        $response = $this->actingAs($studentUser)->post(route('registrations.store'), [
            'course_id' => $courseToRegister->id,
            'academic_year' => '2026/2027',
            'semester' => 'Semester I',
        ]);

        $response->assertRedirect(route('registrations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('course_registrations', [
            'student_id' => $student->id,
            'course_id' => $courseToRegister->id,
        ]);

        // 2. Duplicate registration attempt - MUST BE REJECTED
        $duplicateResponse = $this->actingAs($studentUser)->post(route('registrations.store'), [
            'course_id' => $courseToRegister->id,
            'academic_year' => '2026/2027',
            'semester' => 'Semester I',
        ]);

        $duplicateResponse->assertSessionHas('error');
    }

    /**
     * Question 5d: Display navigation links and views according to permissions.
     */
    public function test_blade_layout_displays_role_appropriate_navigation(): void
    {
        $admin = User::where('email', 'admin@mubs.ac.ug')->first();
        $studentUser = User::where('email', '2400711902@mubs.ac.ug')->first();

        // Admin sees "Students" and "Admin Dashboard"
        $adminResponse = $this->actingAs($admin)->get(route('admin.dashboard'));
        $adminResponse->assertSee('Admin Dashboard');
        $adminResponse->assertSee('Students');

        // Student does not see "Admin Dashboard"
        $studentResponse = $this->actingAs($studentUser)->get(route('student.dashboard'));
        $studentResponse->assertSee('Student Portal');
        $studentResponse->assertDontSee('Admin Dashboard');
    }
}
