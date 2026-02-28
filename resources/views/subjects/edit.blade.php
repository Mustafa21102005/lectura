@extends('layouts.dashboard')

@section('title', 'Edit Subject')

@section('page_header', 'Edit Subject')

@section('content')
    <div class="container my-auto">
        <div class="row">
            <div class="col-12">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Edit Subject</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Error Alert --}}
                        <x-error-alert />

                        <form role="form" method="POST" action="{{ route('subjects.update', $subject) }}">
                            @csrf
                            @method('PUT')

                            {{-- Subject Name --}}
                            <div class="input-group input-group-outline my-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    value="{{ $subject->name }}" required>
                            </div>

                            {{-- Curriculum --}}
                            <div class="input-group my-3">
                                <label for="curricula">Curriculums</label>
                                <select class="form-control" id="curricula" name="curricula[]" multiple required>
                                    @foreach ($curriculums as $curriculum)
                                        <option value="{{ $curriculum->id }}"
                                            {{ $subject->curricula->contains($curriculum->id) ? 'selected' : '' }}>
                                            {{ $curriculum->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Teacher --}}
                            <div class="input-group my-3">
                                <label for="teacher_id">Teacher</label>
                                <select class="form-control" id="teacher_id" name="teacher_id" required>
                                    <option {{ $subject->teacher_id ? '' : 'selected' }} disabled>Select Teacher</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                            {{ optional($subject->assignedTeachers->first())->id == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Grade Level --}}
                            <div class="input-group my-3">
                                <label for="grade_levels">Grade Levels</label>
                                <select class="form-control" id="grade_levels" name="grade_levels[]" multiple required>
                                    @foreach ($gradeLevels as $level)
                                        <option value="{{ $level->id }}"
                                            {{ in_array($level->id, $assignedGradeLevels) ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary me-2">Update</button>
                                <x-cancel-button :route="route('subjects.index')" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('dashboard/assets/js/grade-level-select.js') }}"></script>
@endsection
