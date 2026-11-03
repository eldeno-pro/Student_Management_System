<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of students (Question 4a & 4d).
     */
    public function index(Request $request): View|RedirectResponse
    {
        $user = Auth::user();

        // Admin: View all students
        if ($user->hasRole('admin')) {
            $students = Student::with(['user', 'courses'])->latest()->paginate(10);
            return view('students.index', compact('students'));
        }

        // Lecturer: View students registered in courses taught by this lecturer
        if ($user->hasRole('lecturer')) {
            $students = Student::whereHas('courses', function ($query) use ($user) {
                $query->where('lecturer_id', $user->id);
            })->with(['courses' => function ($q) use ($user) {
                $q->where('lecturer_id', $user->id);
            }])->paginate(10);

            return view('students.index', compact('students'));
        }

        // Student: View only their own profile
        $student = $user->student;
        if (! $student) {
            return redirect()->route('student.dashboard')->with('error', 'Student profile not found.');
        }

        return redirect()->route('students.show', $student);
    }

    /**
     * Show the form for creating a new student (Question 4a).
     */
    public function create(): View
    {
        $this->authorizeAdmin();

        $unlinkedUsers = User::role('student')
            ->doesntHave('student')
            ->get();

        return view('students.create', compact('unlinkedUsers'));
    }

    /**
     * Store a newly created student (Question 4a & 5c).
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'student_number' => ['required', 'string', 'max:50', 'unique:students,student_number'],
            'registration_number' => ['required', 'string', 'max:50', 'unique:students,registration_number'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'in:Male,Female,Other'],
            'program' => ['required', 'string', 'max:150'],
            'year_of_study' => ['required', 'integer', 'between:1,5'],
            'semester' => ['required', 'integer', 'between:1,2'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $student = Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', "Student {$student->name} created successfully!");
    }

    /**
     * Display the specified student (Question 4a).
     */
    public function show(Student $student): View
    {
        Gate::authorize('view', $student);

        $student->load(['courses.lecturer', 'registrations.course']);

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the student (Question 4a).
     */
    public function edit(Student $student): View
    {
        Gate::authorize('update', $student);

        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student (Question 4a & 5c).
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        Gate::authorize('update', $student);

        $validated = $request->validate([
            'student_number' => ['required', 'string', 'max:50', 'unique:students,student_number,' . $student->id],
            'registration_number' => ['required', 'string', 'max:50', 'unique:students,registration_number,' . $student->id],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email,' . $student->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'in:Male,Female,Other'],
            'program' => ['required', 'string', 'max:150'],
            'year_of_study' => ['required', 'integer', 'between:1,5'],
            'semester' => ['required', 'integer', 'between:1,2'],
        ]);

        $student->update($validated);

        return redirect()->route('students.show', $student)
            ->with('success', "Student {$student->name} updated successfully!");
    }

    /**
     * Remove the specified student (Question 4a).
     */
    public function destroy(Student $student): RedirectResponse
    {
        $this->authorizeAdmin();

        $name = $student->name;
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', "Student {$name} deleted successfully!");
    }

    protected function authorizeAdmin(): void
    {
        if (! Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized access: Administrator role required.');
        }
    }
}
