<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_number',
        'registration_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'program',
        'year_of_study',
        'semester',
        'status',
    ];

    /**
     * Get the student's full name.
     */
    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Relationship: Student belongs to a User account (Question 1b)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Student has many Course Registrations (Question 1b)
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(CourseRegistration::class);
    }

    /**
     * Relationship: Student belongs to many Courses through course registrations (Question 1b)
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_registrations', 'student_id', 'course_id')
            ->withPivot('id', 'academic_year', 'semester', 'status', 'registered_at')
            ->withTimestamps();
    }

    /**
     * Retrieve a student's registered courses using Eloquent (Question 1c)
     */
    public function registeredCourses()
    {
        return $this->courses()->wherePivot('status', '!=', 'dropped')->get();
    }
}
