@extends('layouts.dashboard')

@section('title', 'Edit User')

@section('page_header', 'Edit User')

@section('content')
    <div class="container my-auto">
        <div class="row">
            <div class="col-12">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Edit User</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Error Alert --}}
                        <x-error-alert />

                        <form role="form" method="POST" action="{{ route('users.update', $user) }}">
                            @csrf
                            @method('PUT')

                            {{-- User Name --}}
                            <div class="input-group input-group-outline my-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    value="{{ $user->name }}" required>
                            </div>

                            {{-- User Email --}}
                            <div class="input-group input-group-outline my-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" id="email" name="email" class="form-control"
                                    value="{{ $user->email }}" required>
                            </div>

                            {{-- User Phone Number --}}
                            <div class="input-group input-group-outline my-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    value="{{ $user->phone ?? '' }}">
                            </div>

                            {{-- Student Info --}}
                            @if ($user->hasRole('student'))
                                @php
                                    $pivot = optional($user->curricula->first())->pivot;
                                @endphp

                                {{-- Curriculum --}}
                                <div class="input-group input-group-outline my-3">
                                    <select class="form-control" name="curriculum_id" id="curriculum_id" required>
                                        <option selected disabled>Select Curriculum</option>
                                        @foreach ($curriculums as $curriculum)
                                            <option value="{{ $curriculum->id }}"
                                                {{ $user->curricula->contains($curriculum->id) ? 'selected' : '' }}>
                                                {{ $curriculum->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Grade Level --}}
                                <div class="input-group input-group-outline my-3">
                                    <select class="form-control grade-select" name="grade_level_id" id="grade_level_id"
                                        required>
                                        <option selected disabled>Select Grade</option>
                                        @foreach ($gradeLevels as $grade)
                                            <option value="{{ $grade->id }}"
                                                {{ optional($pivot)->grade_level_id == $grade->id ? 'selected' : '' }}>
                                                {{ $grade->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Section --}}
                                <div class="input-group input-group-outline my-3">
                                    <select class="form-control section-select" name="section_id" id="section_id"
                                        data-selected="{{ optional($pivot)->section_id }}"
                                        {{ empty(optional($pivot)->section_id) ? 'disabled' : '' }}>
                                        <option selected disabled>Select Section</option>
                                        @foreach ($gradeLevels as $grade)
                                            @if (optional($pivot)->grade_level_id == $grade->id)
                                                @foreach ($grade->sections as $section)
                                                    <option value="{{ $section->id }}"
                                                        {{ optional($pivot)->section_id == $section->id ? 'selected' : '' }}>
                                                        {{ $section->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary me-2">Update</button>
                                <x-cancel-button :route="route('users.index')" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#curriculum_id, #grade_level_id, #section_id').select2({
                allowClear: true,
                width: '100%',
                placeholder: ''
            });

            // JSON mapping grade_id => sections [{id, name}, ...]
            const gradeSections = @json(
                $gradeLevels->mapWithKeys(function ($grade) {
                    return [
                        $grade->id => $grade->sections->map(function ($s) {
                            return ['id' => $s->id, 'name' => $s->name];
                        }),
                    ];
                }));

            // Store the initially selected section (from pivot)
            const initialSection = $('#section_id').data('selected') || null;

            // Handle grade change
            $('#grade_level_id').on('change', function() {
                const gradeId = $(this).val();
                const $sectionSelect = $('#section_id');

                // Destroy Select2 to manipulate <select>
                $sectionSelect.select2('destroy');

                // Clear current options
                $sectionSelect.empty().append('<option selected disabled>Select Section</option>');

                if (gradeSections[gradeId] && gradeSections[gradeId].length) {
                    // Enable <select>
                    $sectionSelect.prop('disabled', false);

                    // Add options
                    $.each(gradeSections[gradeId], function(_, section) {
                        const isSelected = initialSection == section.id;
                        $sectionSelect.append(new Option(section.name, section.id, isSelected,
                            isSelected));
                    });
                } else {
                    // Disable if no sections
                    $sectionSelect.prop('disabled', true);
                }

                // Re-initialize Select2
                $sectionSelect.select2({
                    allowClear: true,
                    width: '100%',
                    placeholder: ''
                });
            });

            // Trigger change once on page load to populate section for existing grade
            $('#grade_level_id').trigger('change');
        });
    </script>
@endsection
