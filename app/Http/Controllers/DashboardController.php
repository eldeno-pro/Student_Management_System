<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Administrator Dashboard
     */
    public function adminDashboard(): View
    {
        $stats = [
            'total_students' => Student::count(),
            'total_courses' => Course::count(),
            'total_registrations' => CourseRegistration::count(),
            'total_lecturers' => User::role('lecturer')->count(),
        ];

        $recentRegistrations = CourseRegistration::with(['student', 'course'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('stats', 'recentRegistrations'));
    }

    /**
     * Lecturer Dashboard
     */
    public function lecturerDashboard(): View
    {
        $lecturer = Auth::user();

        // Retrieve only courses assigned to this lecturer
        $assignedCourses = Course::where('lecturer_id', $lecturer->id)
            ->withCount('students')
            ->get();

        return view('dashboard.lecturer', compact('lecturer', 'assignedCourses'));
    }

    /**
     * Student Dashboard
     */
    public function studentDashboard(): View
    {
        $user = Auth::user();
        $student = $user->student;

        $registeredCourses = $student ? $student->courses : collect();
        $availableCourses = Course::with('lecturer')->get();

        return view('dashboard.student', compact('user', 'student', 'registeredCourses', 'availableCourses'));
    }
}

