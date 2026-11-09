<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'academic_year',
        'semester',
        'status',
        'registered_at',
    ];

    protected function casts(): array
    {
        return [
            'registered_at' => 'datetime',
        ];
    }

    /**
     * Relationship: Course Registration belongs to a Student (Question 1b)
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relationship: Course Registration belongs to a Course (Question 1b)
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
