<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Student;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CourseRegistrationController extends Controller
{
    /**
     * Display a listing of course registrations (Question 4c & 4d).
     */
    public function index(): View
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $registrations = CourseRegistration::with(['student', 'course.lecturer'])
                ->latest()
                ->paginate(15);
        } elseif ($user->hasRole('lecturer')) {
            $registrations = CourseRegistration::whereHas('course', function ($q) use ($user) {
                $q->where('lecturer_id', $user->id);
            })->with(['student', 'course'])
                ->latest()
                ->paginate(15);
        } else {
            // Student: View only their own registrations
            $student = $user->student;
            $registrations = $student
                ? CourseRegistration::where('student_id', $student->id)->with('course.lecturer')->latest()->paginate(15)
                : collect();
        }

        return view('registrations.index', compact('registrations'));
    }

    /**
     * Show the form for creating a new course registration (Question 4c).
     */
    public function create(): View|RedirectResponse
    {
        $user = Auth::user();

        if ($user->hasRole('student')) {
            $student = $user->student;
            if (! $student) {
                return redirect()->route('student.dashboard')
                    ->with('error', 'Please complete your student profile before registering for courses.');
            }

            // Exclude courses already registered
            $registeredIds = $student->courses->pluck('id')->toArray();
            $availableCourses = Course::whereNotIn('id', $registeredIds)->with('lecturer')->get();

            return view('registrations.create', compact('student', 'availableCourses'));
        }

        // Admin: Can register any student for any course
        $students = Student::all();
        $courses = Course::with('lecturer')->get();

        return view('registrations.create', compact('students', 'courses'));
    }

    /**
     * Store a newly created course registration with duplicate prevention (Question 4c & 1d).
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Determine student ID
        if ($user->hasRole('student')) {
            $student = $user->student;
            if (! $student) {
                return back()->with('error', 'Student record not found.');
            }
            $studentId = $student->id;
        } else {
            $this->authorizeAdmin();
            $request->validate([
                'student_id' => ['required', 'exists:students,id'],
            ]);
            $studentId = $request->input('student_id');
        }

        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'academic_year' => ['nullable', 'string', 'max:20'],
            'semester' => ['nullable', 'string', 'max:20'],
        ]);

        $courseId = $validated['course_id'];

        // 1. Application-level Duplicate Check (Question 4c)
        $exists = CourseRegistration::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Duplicate Registration: The student is already registered for this course.');
        }

        // 2. Database-level persistence with duplicate exception safety
        try {
            $registration = CourseRegistration::create([
                'student_id' => $studentId,
                'course_id' => $courseId,
                'academic_year' => $validated['academic_year'] ?? '2026/2027',
                'semester' => $validated['semester'] ?? 'Semester I',
                'status' => 'registered',
                'registered_at' => now(),
            ]);

            return redirect()->route('registrations.index')
                ->with('success', "Successfully registered for course: {$registration->course->title}!");
        } catch (QueryException $e) {
            return back()->withInput()->with('error', 'Duplicate Registration prevented by database constraint.');
        }
    }

    /**
     * Remove the specified course registration (Drop Course).
     */
    public function destroy(CourseRegistration $registration): RedirectResponse
    {
        Gate::authorize('delete', $registration);

        $courseTitle = $registration->course?->title ?? 'Course';
        $registration->delete();

        return redirect()->route('registrations.index')
            ->with('success', "Registration for '{$courseTitle}' was dropped successfully.");
    }

    protected function authorizeAdmin(): void
    {
        if (! Auth::user()->hasRole('admin')) {
            abort(403, 'Administrator role required.');
        }
    }
}

