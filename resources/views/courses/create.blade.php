@extends('layouts.app')

@section('title', 'Add Course')
@section('page_title', 'Create Course Unit')
@section('page_subtitle', 'Add a new unit to the curriculum and assign a lecturer')

@section('page_actions')
    <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Courses
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('courses.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="code" class="form-label fw-semibold">Course Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" required placeholder="e.g. BUC3131">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="credit_units" class="form-label fw-semibold">Credit Units <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('credit_units') is-invalid @enderror" id="credit_units" name="credit_units" value="{{ old('credit_units', 4) }}" min="1" max="6" required>
                            @error('credit_units')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="title" class="form-label fw-semibold">Course Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. Advanced Web Application Development">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">Course Syllabus / Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Outline the main objectives and topics covered...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="year_of_study" class="form-label fw-semibold">Year of Study <span class="text-danger">*</span></label>
                            <select class="form-select @error('year_of_study') is-invalid @enderror" id="year_of_study" name="year_of_study" required>
                                <option value="1" {{ old('year_of_study') == '1' ? 'selected' : '' }}>Year I</option>
                                <option value="2" {{ old('year_of_study') == '2' ? 'selected' : '' }}>Year II</option>
                                <option value="3" {{ old('year_of_study', '3') == '3' ? 'selected' : '' }}>Year III</option>
                                <option value="4" {{ old('year_of_study') == '4' ? 'selected' : '' }}>Year IV</option>
                            </select>
                            @error('year_of_study')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="semester" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                            <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                                <option value="1" {{ old('semester', '1') == '1' ? 'selected' : '' }}>Semester I</option>
                                <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Semester II</option>
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="lecturer_id" class="form-label fw-semibold">Assign Lecturer (Question 1b: Course belongsTo Lecturer)</label>
                            <select class="form-select @error('lecturer_id') is-invalid @enderror" id="lecturer_id" name="lecturer_id">
                                <option value="">-- Select Lecturer --</option>
                                @foreach ($lecturers as $lecturer)
                                    <option value="{{ $lecturer->id }}" {{ old('lecturer_id') == $lecturer->id ? 'selected' : '' }}>
                                        {{ $lecturer->name }} ({{ $lecturer->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('lecturer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Save Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
