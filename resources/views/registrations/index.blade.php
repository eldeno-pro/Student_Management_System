@extends('layouts.app')

@section('title', 'Course Registrations')
@section('page_title', 'Course Registrations')
@section('page_subtitle', 'Audit and verify student course enrolments')

@section('page_actions')
    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('student'))
        <a href="{{ route('registrations.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle-fill me-1"></i> Register for Course
        </a>
    @endif
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Reg ID</th>
                        <th>Student Name & No.</th>
                        <th>Course</th>
                        <th>Academic Year / Semester</th>
                        <th>Status</th>
                        <th>Date Registered</th>
                        <th class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($registrations as $reg)
                        <tr>
                            <td class="ps-3 text-muted">#{{ $reg->id }}</td>
                            <td>
                                <a href="{{ route('students.show', $reg->student) }}" class="fw-semibold text-decoration-none">
                                    {{ $reg->student?->name }}
                                </a>
                                <div class="small text-muted">{{ $reg->student?->student_number }}</div>
                            </td>
                            <td>
                                <a href="{{ route('courses.show', $reg->course) }}" class="fw-semibold text-dark text-decoration-none">
                                    [{{ $reg->course?->code }}] {{ $reg->course?->title }}
                                </a>
                                <div class="small text-muted">Lecturer: {{ $reg->course?->lecturer?->name ?? 'Unassigned' }}</div>
                            </td>
                            <td>
                                <div>{{ $reg->academic_year }}</div>
                                <small class="text-muted">{{ $reg->semester }}</small>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success text-capitalize">{{ $reg->status }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ optional($reg->created_at)->format('d M Y, H:i') ?? 'N/A' }}</small>
                            </td>
                            <td class="text-end pe-3">
                                @can('delete', $reg)
                                    <form method="POST" action="{{ route('registrations.destroy', $reg) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to drop/cancel this course registration?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Drop Registration">
                                            <i class="bi bi-x-circle me-1"></i> Drop
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-card-checklist fs-1 d-block text-secondary mb-2"></i>
                                No course registrations found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if (method_exists($registrations, 'hasPages') && $registrations->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $registrations->links() }}
        </div>
    @endif
</div>
@endsection
