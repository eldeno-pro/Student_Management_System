<?php

namespace App\Policies;

use App\Models\CourseRegistration;
use App\Models\User;

class CourseRegistrationPolicy
{
    /**
     * Determine whether the user can view any course registrations.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('lecturer');
    }

    /**
     * Determine whether the user can view the specific course registration (Question 3e).
     */
    public function view(User $user, CourseRegistration $registration): bool
    {
        // Admin can view all registrations
        if ($user->hasRole('admin')) {
            return true;
        }

        // Student can only view their own course registration
        if ($user->hasRole('student')) {
            return $registration->student?->user_id === $user->id;
        }

        // Lecturer can only view registrations for courses assigned to them
        if ($user->hasRole('lecturer')) {
            return $registration->course?->lecturer_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can register for a course.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('student');
    }

    /**
     * Determine whether the user can delete/drop a registration.
     */
    public function delete(User $user, CourseRegistration $registration): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('student')) {
            return $registration->student?->user_id === $user->id;
        }

        return false;
    }
}

