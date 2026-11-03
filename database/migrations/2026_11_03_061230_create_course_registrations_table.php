<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('academic_year', 20)->default('2026/2027');
            $table->string('semester', 20)->default('Semester I');
            $table->string('status', 30)->default('registered');
            $table->timestamp('registered_at')->nullable();
            $table->timestamps();

            // Prevent duplicate course registrations for the same student (Question 1d)
            $table->unique(['student_id', 'course_id'], 'unique_student_course_registration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_registrations');
    }
};
