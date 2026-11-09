<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Display a listing of courses (Question 4b & 4d).
     */
    public function index(): View
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $courses = Course::with('lecturer')->withCount('students')->latest()->paginate(10);
        } elseif ($user->hasRole('lecturer')) {
            $courses = Course::where('lecturer_id', $user->id)->withCount('students')->latest()->paginate(10);
        } else {
            // Student: View available courses with their registration status
            $student = $user->student;
            $registeredCourseIds = $student ? $student->courses->pluck('id')->toArray() : [];
            $courses = Course::with('lecturer')->withCount('students')->latest()->paginate(10);

            return view('courses.index', compact('courses', 'registeredCourseIds'));
        }

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course (Question 4b).
     */
    public function create(): View
    {
        $this->authorizeAdmin();

        $lecturers = User::role('lecturer')->get();

        return view('courses.create', compact('lecturers'));
    }

    /**
     * Store a newly created course (Question 4b & 5c).
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:courses,code'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'credit_units' => ['required', 'integer', 'between:1,6'],
            'year_of_study' => ['required', 'integer', 'between:1,5'],
            'semester' => ['required', 'integer', 'between:1,2'],
            'lecturer_id' => ['nullable', 'exists:users,id'],
        ]);

        $course = Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', "Course [{$course->code}] {$course->title} created successfully!");
    }

    /**
     * Display the specified course (Question 4b).
     */
    public function show(Course $course): View
    {
        $course->load(['lecturer', 'students.user']);

        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the course (Question 4b).
     */
    public function edit(Course $course): View
    {
        $this->authorizeAdmin();

        $lecturers = User::role('lecturer')->get();

        return view('courses.edit', compact('course', 'lecturers'));
    }

    /**
     * Update the specified course (Question 4b & 5c).
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:courses,code,' . $course->id],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'credit_units' => ['required', 'integer', 'between:1,6'],
            'year_of_study' => ['required', 'integer', 'between:1,5'],
            'semester' => ['required', 'integer', 'between:1,2'],
            'lecturer_id' => ['nullable', 'exists:users,id'],
        ]);

        $course->update($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', "Course [{$course->code}] updated successfully!");
    }

    /**
     * Remove the specified course (Question 4b).
     */
    public function destroy(Course $course): RedirectResponse
    {
        $this->authorizeAdmin();

        $code = $course->code;
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', "Course [{$code}] deleted successfully!");
    }

    protected function authorizeAdmin(): void
    {
        if (! Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized access: Administrator role required.');
        }
    }
}

