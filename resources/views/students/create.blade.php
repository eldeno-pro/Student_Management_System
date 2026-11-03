@extends('layouts.app')

@section('title', 'Add New Student')
@section('page_title', 'Create Student Record')
@section('page_subtitle', 'Enroll a new student into Makerere University Business School')

@section('page_actions')
    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Students List
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('students.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="last_name" class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="student_number" class="form-label fw-semibold">Student Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('student_number') is-invalid @enderror" id="student_number" name="student_number" value="{{ old('student_number') }}" required placeholder="e.g. 2400711902">
                            @error('student_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="registration_number" class="form-label fw-semibold">Registration Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('registration_number') is-invalid @enderror" id="registration_number" name="registration_number" value="{{ old('registration_number') }}" required placeholder="e.g. 24/U/1902/EVE">
                            @error('registration_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="e.g. denis@mubs.ac.ug">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="e.g. +256701234567">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="gender" class="form-label fw-semibold">Gender</label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="program" class="form-label fw-semibold">Degree Program <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('program') is-invalid @enderror" id="program" name="program" value="{{ old('program', 'Bachelor of Business Computing') }}" required>
                            @error('program')
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
                            <label for="user_id" class="form-label fw-semibold">Link to User Account (Optional)</label>
                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                                <option value="">-- No User Account Linked --</option>
                                @foreach ($unlinkedUsers as $unlinkedUser)
                                    <option value="{{ $unlinkedUser->id }}" {{ old('user_id') == $unlinkedUser->id ? 'selected' : '' }}>
                                        {{ $unlinkedUser->name }} ({{ $unlinkedUser->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Save Student Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
