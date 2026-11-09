@extends('layouts.app')

@section('title', 'Student Portal')
@section('page_title', 'Student Portal')
@section('page_subtitle', 'Welcome back, ' . ($student->name ?? $user->name) . ' — ' . ($student->program ?? 'Bachelor of Business Computing'))

@section('page_actions')
    <a href="{{ route('registrations.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Register for a Course
    </a>
@endsection

@section('content')
<div class="row g-4 mb-4">
    <!-- Student Status Card -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 fw-bold border-bottom">
                <i class="bi bi-person-badge text-primary me-2"></i> Student Identification
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="fw-bold fs-5">{{ $student->name ?? $user->name }}</div>
                    <div class="text-muted small">{{ $user->email }}</div>
                </div>

                @if($student)
                    <ul class="list-unstyled small mb-0">
                        <li class="py-1"><strong>Student No:</strong> <code>{{ $student->student_number }}</code></li>
                        <li class="py-1"><strong>Registration No:</strong> <code>{{ $student->registration_number }}</code></li>
                        <li class="py-1"><strong>Academic Standing:</strong> Year {{ $student->year_of_study }}, Sem {{ $student->semester }}</li>
                        <li class="py-1"><strong>Program:</strong> {{ $student->program }}</li>
                    </ul>
                @else
                    <div class="alert alert-warning small mb-0">Profile incomplete. Contact administrator.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-md-8">
        <div class="row g-3">
            <div class="col-sm-6">
                <div class="card shadow-sm border-0 card-stat">
                    <div class="card-body">
                        <div class="text-muted small fw-semibold text-uppercase">My Registered Courses</div>
                        <h2 class="fw-bold mb-0 text-primary">{{ $registeredCourses->count() }}</h2>
                        <a href="{{ route('registrations.index') }}" class="stretched-link small text-decoration-none mt-2 d-inline-block">View details &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card shadow-sm border-0 card-stat" style="border-left-color: #198754 !important;">
                    <div class="card-body">
                        <div class="text-muted small fw-semibold text-uppercase">Total Credit Load</div>
                        <h2 class="fw-bold mb-0 text-success">{{ $registeredCourses->sum('credit_units') }} CU</h2>
                        <span class="small text-muted mt-2 d-inline-block">Semester I Load</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- My Registered Courses Table -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-card-checklist text-primary me-2"></i> My Registered Courses (Semester I)
        </h5>
        <a href="{{ route('registrations.create') }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus-lg"></i> Register Course
        </a>
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
                    @forelse ($registeredCourses as $course)
                        <tr>
                            <td class="ps-3 fw-bold text-primary"><code>{{ $course->code }}</code></td>
                            <td class="fw-semibold">{{ $course->title }}</td>
                            <td>{{ $course->lecturer?->name ?? 'TBA' }}</td>
                            <td>{{ $course->credit_units }} CU</td>
                            <td>{{ $course->pivot->semester }}</td>
                            <td class="text-end pe-3">
                                @if(optional($course->pivot)->id)
                                    <form method="POST" action="{{ route('registrations.destroy', $course->pivot->id) }}" class="d-inline" onsubmit="return confirm('Drop this course?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Drop Course">
                                            <i class="bi bi-x-circle me-1"></i> Drop
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                You have not registered for any courses yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
