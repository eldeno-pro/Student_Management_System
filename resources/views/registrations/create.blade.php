@extends('layouts.app')

@section('title', 'Register for Course')
@section('page_title', 'Course Unit Registration')
@section('page_subtitle', 'Enroll into semester course units (Duplicate registrations are prevented)')

@section('page_actions')
    <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Registrations
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 fw-bold border-bottom">
                <i class="bi bi-pencil-square text-primary me-2"></i> Course Registration Form
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('registrations.store') }}">
                    @csrf

                    @if(auth()->user()->hasRole('admin'))
                        <!-- Administrator selects student -->
                        <div class="mb-3">
                            <label for="student_id" class="form-label fw-semibold">Select Student <span class="text-danger">*</span></label>
                            <select class="form-select @error('student_id') is-invalid @enderror" id="student_id" name="student_id" required>
                                <option value="">-- Choose Student --</option>
                                @foreach ($students as $stu)
                                    <option value="{{ $stu->id }}" {{ old('student_id') == $stu->id ? 'selected' : '' }}>
                                        {{ $stu->name }} ({{ $stu->student_number }} - {{ $stu->program }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @else
                        <!-- Student sees their pre-filled identity -->
                        <div class="alert alert-info py-2 small mb-3">
                            <strong>Registering As:</strong> {{ $student->name }} ({{ $student->student_number }} - {{ $student->program }})
                        </div>
                    @endif

                    <!-- Select Course -->
                    <div class="mb-3">
                        <label for="course_id" class="form-label fw-semibold">Select Course Unit <span class="text-danger">*</span></label>
                        <select class="form-select @error('course_id') is-invalid @enderror" id="course_id" name="course_id" required>
                            <option value="">-- Choose Course --</option>
                            @if(isset($availableCourses))
                                @foreach ($availableCourses as $c)
                                    <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>
                                        [{{ $c->code }}] {{ $c->title }} ({{ $c->credit_units }} CU) - Lecturer: {{ $c->lecturer?->name ?? 'TBA' }}
                                    </option>
                                @endforeach
                            @elseif(isset($courses))
                                @foreach ($courses as $c)
                                    <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>
                                        [{{ $c->code }}] {{ $c->title }} ({{ $c->credit_units }} CU) - Lecturer: {{ $c->lecturer?->name ?? 'TBA' }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('course_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="academic_year" class="form-label fw-semibold">Academic Year</label>
                            <input type="text" class="form-control @error('academic_year') is-invalid @enderror" id="academic_year" name="academic_year" value="{{ old('academic_year', '2026/2027') }}" required>
                            @error('academic_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="semester" class="form-label fw-semibold">Semester</label>
                            <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                                <option value="Semester I" {{ old('semester') == 'Semester I' ? 'selected' : '' }}>Semester I</option>
                                <option value="Semester II" {{ old('semester') == 'Semester II' ? 'selected' : '' }}>Semester II</option>
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="alert alert-warning py-2 small mt-4 mb-0">
                        <i class="bi bi-shield-check me-1"></i> <strong>Validation & Duplicate Protection:</strong> You cannot register for the same course unit twice.
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check2-circle me-1"></i> Submit Registration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
