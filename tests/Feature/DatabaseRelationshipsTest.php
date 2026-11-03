<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Question 1b & 1c: Test hasMany, belongsTo, belongsToMany and Eloquent retrieval.
     */
    public function test_relationships_and_eloquent_retrieval(): void
    {
        // 1. Create a Lecturer (User)
        $lecturer = User::create([
            'name' => 'Bashir Mutebi',
            'email' => 'bmutebi@mubs.ac.ug',
            'password' => bcrypt('password123'),
        ]);

        // 2. Create Course belonging to Lecturer (belongsTo & hasMany)
        $course = Course::create([
            'code' => 'BUC3131',
            'title' => 'Advanced Web Application Development',
            'credit_units' => 4,
            'year_of_study' => 3,
            'semester' => 1,
            'lecturer_id' => $lecturer->id,
        ]);

        $this->assertEquals($lecturer->id, $course->lecturer->id);
        $this->assertTrue($lecturer->taughtCourses->contains($course));

        // 3. Create Student
        $student = Student::create([
            'student_number' => '2400711902',
            'registration_number' => '24/U/1902/EVE',
            'first_name' => 'Denis',
            'last_name' => 'Wawomola',
            'email' => '2400711902@mubs.ac.ug',
            'program' => 'Bachelor of Business Computing',
            'year_of_study' => 3,
            'semester' => 1,
        ]);

        // 4. Register Student to Course
        $registration = CourseRegistration::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'academic_year' => '2026/2027',
            'semester' => 'Semester I',
            'status' => 'registered',
        ]);

        // Assert belongsTo relationships on CourseRegistration
        $this->assertEquals($student->id, $registration->student->id);
        $this->assertEquals($course->id, $registration->course->id);

        // Assert hasMany relationships
        $this->assertTrue($student->registrations->contains($registration));
        $this->assertTrue($course->registrations->contains($registration));

        // Assert Question 1c: Retrieve student's registered courses
        $this->assertCount(1, $student->courses);
        $this->assertEquals('BUC3131', $student->courses->first()->code);

        // Assert Question 1c: Retrieve students registered for a course
        $this->assertCount(1, $course->students);
        $this->assertEquals('Denis Wawomola', $course->students->first()->name);
    }

    /**
     * Question 1d: Test prevention of duplicate registrations at database level.
     */
    public function test_prevents_duplicate_course_registrations(): void
    {
        $student = Student::create([
            'student_number' => '2400711902',
            'registration_number' => '24/U/1902/EVE',
            'first_name' => 'Denis',
            'last_name' => 'Wawomola',
            'email' => '2400711902@mubs.ac.ug',
        ]);

        $course = Course::create([
            'code' => 'BUC3131',
            'title' => 'Advanced Web Application Development',
            'credit_units' => 4,
        ]);

        // First registration succeeds
        CourseRegistration::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'academic_year' => '2026/2027',
            'semester' => 'Semester I',
        ]);

        // Second registration must fail with unique constraint QueryException
        $this->expectException(QueryException::class);

        CourseRegistration::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'academic_year' => '2026/2027',
            'semester' => 'Semester I',
        ]);
    }
}
