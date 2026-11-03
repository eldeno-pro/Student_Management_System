@extends('layouts.app')

@section('title', 'Student Profile - ' . $student->name)
@section('page_title', $student->name)
@section('page_subtitle', $student->program . ' — Year ' . $student->year_of_study . ', Semester ' . $student->semester)

@section('page_actions')
    <div class="btn-group">
        @can('manage-students')
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Students List
            </a>
            <a href="{{ route('students.edit', $student) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil me-1"></i> Edit Profile
            </a>
        @endcan
        @if(auth()->user()->hasRole('student'))
            <a href="{{ route('registrations.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Register for Course
            </a>
        @endif
    </div>
@endsection

@section('content')
<div class="row g-4">
    <!-- Student Information Card -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 fw-bold border-bottom">
                <i class="bi bi-person-lines-fill text-primary me-2"></i> Biodata & Academic Profile
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="display-5 text-primary mb-2">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h5 class="fw-bold mb-0">{{ $student->name }}</h5>
                    <span class="badge bg-primary-subtle text-primary">{{ $student->student_number }}</span>
                </div>

                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Registration No:</span>
                        <span class="fw-semibold">{{ $student->registration_number }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Email:</span>
                        <span>{{ $student->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Phone:</span>
                        <span>{{ $student->phone ?? 'Not Provided' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Gender:</span>
                        <span>{{ $student->gender ?? 'Not Specified' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Status:</span>
                        <span class="badge bg-success-subtle text-success">{{ $student->status }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Registered Courses Table (Question 1c Eloquent Retrieval) -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <div class="fw-bold">
                    <i class="bi bi-journals text-primary me-2"></i> Registered Courses (Question 1c: $student->courses)
                </div>
                <span class="badge bg-secondary">{{ $student->courses->count() }} Enrolled</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Code</th>
                                <th>Course Title</th>
                                <th>Lecturer</th>
                                <th>Credit Units</th>
                                <th>Semester</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($student->courses as $course)
                                <tr>
                                    <td class="ps-3 fw-bold text-primary">{{ $course->code }}</td>
                                    <td>
                                        <a href="{{ route('courses.show', $course) }}" class="text-decoration-none fw-semibold">
                                            {{ $course->title }}
                                        </a>
                                    </td>
                                    <td>{{ $course->lecturer?->name ?? 'TBA' }}</td>
                                    <td>{{ $course->credit_units }} CU</td>
                                    <td>{{ $course->pivot->semester }}</td>
                                    <td class="text-end pe-3">
                                        @can('delete', $course->pivot)
                                            <form method="POST" action="{{ route('registrations.destroy', $course->pivot->id) }}" class="d-inline" onsubmit="return confirm('Drop this course?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Drop Course">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                        No courses registered for this student yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
