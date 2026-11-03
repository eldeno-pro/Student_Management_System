@extends('layouts.app')

@section('title', 'Administrator Dashboard')
@section('page_title', 'Administrator Portal')
@section('page_subtitle', 'Overview of students, courses, registrations, and academic staff')

@section('page_actions')
    <div class="btn-group">
        <a href="{{ route('students.create') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-person-plus me-1"></i> Add Student
        </a>
        <a href="{{ route('courses.create') }}" class="btn btn-outline-success btn-sm">
            <i class="bi bi-journal-plus me-1"></i> Add Course
        </a>
        <a href="{{ route('registrations.create') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-card-checklist me-1"></i> New Registration
        </a>
    </div>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 card-stat">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Total Students</div>
                        <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_students'] }}</h3>
                    </div>
                    <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                </div>
                <a href="{{ route('students.index') }}" class="stretched-link small text-decoration-none mt-2 d-inline-block">View all students &rarr;</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 card-stat" style="border-left-color: #0d6efd !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Active Courses</div>
                        <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_courses'] }}</h3>
                    </div>
                    <div class="bg-info-subtle text-info p-3 rounded-circle">
                        <i class="bi bi-journal-code fs-4"></i>
                    </div>
                </div>
                <a href="{{ route('courses.index') }}" class="stretched-link small text-decoration-none mt-2 d-inline-block">View all courses &rarr;</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 card-stat" style="border-left-color: #198754 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Registrations</div>
                        <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_registrations'] }}</h3>
                    </div>
                    <div class="bg-success-subtle text-success p-3 rounded-circle">
                        <i class="bi bi-card-checklist fs-4"></i>
                    </div>
                </div>
                <a href="{{ route('registrations.index') }}" class="stretched-link small text-decoration-none mt-2 d-inline-block">Audit registrations &rarr;</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card shadow-sm border-0 card-stat" style="border-left-color: #6f42c1 !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Lecturers</div>
                        <h3 class="fw-bold mb-0 text-dark">{{ $stats['total_lecturers'] }}</h3>
                    </div>
                    <div class="bg-purple-subtle text-primary p-3 rounded-circle">
                        <i class="bi bi-person-workspace fs-4"></i>
                    </div>
                </div>
                <span class="small text-muted mt-2 d-inline-block">Academic Staff</span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Course Registrations Table -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
        <h5 class="card-title fw-bold mb-0">Recent Course Registrations</h5>
        <a href="{{ route('registrations.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Student</th>
                        <th>Course</th>
                        <th>Academic Year</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentRegistrations as $reg)
                        <tr>
                            <td class="ps-3">
                                <strong>{{ $reg->student?->name }}</strong>
                                <div class="small text-muted">{{ $reg->student?->student_number }}</div>
                            </td>
                            <td>
                                <div>[{{ $reg->course?->code }}] {{ $reg->course?->title }}</div>
                                <small class="text-muted">Lecturer: {{ $reg->course?->lecturer?->name ?? 'Unassigned' }}</small>
                            </td>
                            <td>{{ $reg->academic_year }} ({{ $reg->semester }})</td>
                            <td><span class="badge bg-success-subtle text-success">{{ $reg->status }}</span></td>
                            <td><small class="text-muted">{{ optional($reg->created_at)->format('d M Y') }}</small></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No recent registrations.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
