@extends('layouts.app')

@section('title', 'Courses Catalog')
@section('page_title', 'Course Curriculum')
@section('page_subtitle', 'Bachelor of Business Computing curriculum and course allocations')

@section('page_actions')
    @can('manage-courses')
        <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle-fill me-1"></i> Add New Course
        </a>
    @endcan
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Code</th>
                        <th>Course Title</th>
                        <th>Lecturer Assigned</th>
                        <th>Credit Units</th>
                        <th>Enrolled Students</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courses as $course)
                        <tr>
                            <td class="ps-3 fw-bold text-primary"><code>{{ $course->code }}</code></td>
                            <td>
                                <div class="fw-semibold">{{ $course->title }}</div>
                                <small class="text-muted">Year {{ $course->year_of_study }}, Sem {{ $course->semester }}</small>
                            </td>
                            <td>
                                @if ($course->lecturer)
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        <i class="bi bi-person me-1"></i> {{ $course->lecturer->name }}
                                    </span>
                                @else
                                    <span class="text-muted small fst-italic">Unassigned</span>
                                @endif
                            </td>
                            <td><span class="badge bg-info-subtle text-info">{{ $course->credit_units }} CU</span></td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary">
                                    {{ $course->students_count }} Students
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-info" title="View Course & Enrolled Students">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if (auth()->user()->hasRole('student') && isset($registeredCourseIds))
                                    @if (in_array($course->id, $registeredCourseIds))
                                        <span class="badge bg-success ms-1">Enrolled</span>
                                    @else
                                        <form method="POST" action="{{ route('registrations.store') }}" class="d-inline ms-1">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <button type="submit" class="btn btn-sm btn-success" title="Quick Register">
                                                <i class="bi bi-plus-lg"></i> Register
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                @can('manage-courses')
                                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('courses.destroy', $course) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-journal-x fs-1 d-block text-secondary mb-2"></i>
                                No courses found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($courses->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $courses->links() }}
        </div>
    @endif
</div>
@endsection

