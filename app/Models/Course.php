<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'credit_units',
        'year_of_study',
        'semester',
        'lecturer_id',
    ];

    /**
     * Relationship: Course belongs to a Lecturer (User) (Question 1b)
     */
    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    /**
     * Relationship: Course has many Course Registrations (Question 1b)
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(CourseRegistration::class);
    }

    /**
     * Relationship: Course belongs to many Students through course registrations (Question 1b)
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'course_registrations', 'course_id', 'student_id')
            ->withPivot('academic_year', 'semester', 'status', 'registered_at')
            ->withTimestamps();
    }

    /**
     * Retrieve the students registered for a course using Eloquent (Question 1c)
     */
    public function registeredStudents()
    {
        return $this->students()->wherePivot('status', '!=', 'dropped')->get();
    }
}
