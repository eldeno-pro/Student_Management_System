@extends('layouts.app')

@section('title', $course->code . ' - ' . $course->title)
@section('page_title', '[' . $course->code . '] ' . $course->title)
@section('page_subtitle', 'Credit Units: ' . $course->credit_units . ' CU | Year ' . $course->year_of_study . ', Semester ' . $course->semester)

@section('page_actions')
    <div class="btn-group">
        <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Courses
        </a>
        @can('manage-courses')
            <a href="{{ route('courses.edit', $course) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil me-1"></i> Edit Course
            </a>
        @endcan
    </div>
@endsection

@section('content')
<div class="row g-4">
    <!-- Course Details Card -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 fw-bold border-bottom">
                <i class="bi bi-info-circle text-primary me-2"></i> Course Information
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span class="badge bg-primary fs-6">{{ $course->code }}</span>
                    <span class="badge bg-info text-dark">{{ $course->credit_units }} Credit Units</span>
                </div>

                <p class="text-secondary small">{{ $course->description ?? 'No description provided.' }}</p>

                <hr>

                <div class="mb-2">
                    <span class="text-muted small d-block">Assigned Lecturer:</span>
                    @if ($course->lecturer)
                        <strong>{{ $course->lecturer->name }}</strong><br>
                        <small class="text-muted">{{ $course->lecturer->email }}</small>
                    @else
                        <span class="text-danger small fst-italic">Lecturer not yet assigned.</span>
                    @endif
                </div>

                <div class="mt-3">
                    <span class="text-muted small d-block">Total Registered Students:</span>
                    <span class="fs-4 fw-bold text-success">{{ $course->students->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrolled Students Table (Question 1c Eloquent Retrieval) -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <div class="fw-bold">
                    <i class="bi bi-people-fill text-primary me-2"></i> Enrolled Students (Question 1c: $course->students)
                </div>
                <span class="badge bg-secondary">{{ $course->students->count() }} Students</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Student No.</th>
                                <th>Student Name</th>
                                <th>Program</th>
                                <th>Registered Date</th>
                                <th class="text-end pe-3">Profile</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($course->students as $student)
                                <tr>
                                    <td class="ps-3 fw-bold text-primary">{{ $student->student_number }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $student->name }}</div>
                                        <small class="text-muted">{{ $student->email }}</small>
                                    </td>
                                    <td>{{ $student->program }}</td>
                                    <td>{{ optional($student->pivot->created_at)->format('d M Y') ?? 'N/A' }}</td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="bi bi-person-x fs-2 d-block mb-2 text-secondary"></i>
                                        No students have registered for this course yet.
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
