@extends('layouts.app')

@section('title', 'Lecturer Portal')
@section('page_title', 'Lecturer Portal')
@section('page_subtitle', 'Welcome back, ' . $lecturer->name . ' — Department of Business Computing')

@section('content')
<div class="row g-4">
    <!-- Assigned Courses List -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-journal-check text-primary me-2"></i> My Assigned Courses
                </h5>
                <span class="badge bg-primary">{{ $assignedCourses->count() }} Courses Taught</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Code</th>
                                <th>Course Title</th>
                                <th>Credit Units</th>
                                <th>Year / Sem</th>
                                <th>Enrolled Students</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignedCourses as $c)
                                <tr>
                                    <td class="ps-3 fw-bold text-primary"><code>{{ $c->code }}</code></td>
                                    <td class="fw-semibold">{{ $c->title }}</td>
                                    <td>{{ $c->credit_units }} CU</td>
                                    <td>Year {{ $c->year_of_study }}, Sem {{ $c->semester }}</td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            <i class="bi bi-people me-1"></i> {{ $c->students_count }} Students Enrolled
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('courses.show', $c) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-person-lines-fill me-1"></i> View Students List
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-journal-x fs-1 d-block text-secondary mb-2"></i>
                                        You have not been assigned any courses yet.
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
