<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    /**
     * Determine whether the user can view any student records.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('lecturer');
    }

    /**
     * Determine whether the user can view the specific student record (Question 3e).
     */
    public function view(User $user, Student $student): bool
    {
        // Admins can view any student
        if ($user->hasRole('admin')) {
            return true;
        }

        // Students can only view their own student record
        if ($user->hasRole('student')) {
            return $student->user_id === $user->id;
        }

        // Lecturers can only view students registered in courses taught by this lecturer
        if ($user->hasRole('lecturer')) {
            return $student->courses()
                ->where('lecturer_id', $user->id)
                ->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can create student records.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the student record.
     */
    public function update(User $user, Student $student): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        // Student can update their own record
        if ($user->hasRole('student')) {
            return $student->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the student record.
     */
    public function delete(User $user, Student $student): bool
    {
        return $user->hasRole('admin');
    }
}

