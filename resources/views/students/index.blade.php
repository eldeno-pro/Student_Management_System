@extends('layouts.app')

@section('title', 'Students List')
@section('page_title', 'Student Records')
@section('page_subtitle', 'Manage student admissions, profiles and academic standings')

@section('page_actions')
    @can('manage-students')
        <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-person-plus-fill me-1"></i> Add New Student
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
                        <th class="ps-3">Student No.</th>
                        <th>Registration No.</th>
                        <th>Name</th>
                        <th>Program</th>
                        <th>Year / Sem</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td class="ps-3 fw-bold text-primary">{{ $student->student_number }}</td>
                            <td><code>{{ $student->registration_number }}</code></td>
                            <td>
                                <div class="fw-semibold">{{ $student->name }}</div>
                                <small class="text-muted">{{ $student->email }}</small>
                            </td>
                            <td>{{ $student->program }}</td>
                            <td>Year {{ $student->year_of_study }}, Sem {{ $student->semester }}</td>
                            <td>
                                <span class="badge bg-success-subtle text-success text-capitalize">{{ $student->status }}</span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-info" title="View Profile">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @can('manage-students')
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('students.destroy', $student) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this student record?');">
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
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-people fs-1 d-block text-secondary mb-2"></i>
                                No student records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($students->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $students->links() }}
        </div>
    @endif
</div>
@endsection

