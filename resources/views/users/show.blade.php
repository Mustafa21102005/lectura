@extends('layouts.dashboard')

@section('title', 'User Details')

@section('page_header', 'User Details')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h5 class="text-white text-capitalize ps-3">User Details</h5>

                        @role('teacher')
                            <x-back-button :href="route('teacher.students.index')">
                                My Students
                            </x-back-button>
                        @endrole
                        @role('admin')
                            <x-back-button :href="route('users.index')">
                                Users
                            </x-back-button>
                        @endrole
                    </div>
                </div>
                <div class="card-body px-4 pb-2">
                    <h4 class="text-center my-4">User Information</h4>
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                @role('admin|teacher')
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                @endrole
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Name
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Email
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Phone
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Role
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Email Verified
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @role('admin|teacher')
                                    <td class="text-center">{{ $user->id }}</td>
                                @endrole
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center">{{ $user->email }}</td>
                                <td class="text-center">{{ $user->phone ?? 'No phone number set' }}</td>
                                <td class="text-center">{{ ucfirst($user->roles->first()->name) }}</td>
                                <td class="text-center">
                                    @if ($user->email_verified_at)
                                        <i class="material-icons text-success">check</i>
                                    @else
                                        <i class="material-icons text-danger">close</i>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- Student --}}
                    @if ($user->hasRole('student'))
                        <h4 class="text-center my-4">Parent</h4>
                        <table id="parents" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    @role('admin|teacher')
                                        <th class="text-center">ID</th>
                                    @endrole
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->parents as $parent)
                                    <tr>
                                        @role('admin|teacher')
                                            <td class="text-center">{{ $parent->id }}</td>
                                        @endrole
                                        <td class="text-center">
                                            <a href="{{ route('users.show', $parent) }}">
                                                {{ $parent->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $parent->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h4 class="text-center my-4">Enrolled In</h4>
                        <table id="student" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    @role('admin|teacher')
                                        <th class="text-center">ID</th>
                                    @endrole
                                    <th class="text-center">Curriculum</th>
                                    <th class="text-center">Grade Level</th>
                                    <th class="text-center">Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->curricula as $curriculum)
                                    <tr>
                                        @role('admin|teacher')
                                            <td class="text-center">{{ $curriculum->id }}</td>
                                        @endrole
                                        <td class="text-center">
                                            <a href="{{ route('curriculums.show', $curriculum) }}">
                                                {{ $curriculum->name }}
                                            </a>
                                        </td>

                                        {{-- Grade Level --}}
                                        <td class="text-center">
                                            @php
                                                $gradeLevel = optional(
                                                    $curriculum->gradeLevels->firstWhere(
                                                        'id',
                                                        $curriculum->pivot->grade_level_id,
                                                    ),
                                                );
                                            @endphp

                                            @if ($gradeLevel)
                                                <a href="{{ route('grade-levels.show', $gradeLevel->slug) }}">
                                                    {{ $gradeLevel->name }}
                                                </a>
                                            @endif
                                        </td>

                                        {{-- Section --}}
                                        <td class="text-center">
                                            @php
                                                $section = optional(
                                                    $curriculum->sections->firstWhere(
                                                        'id',
                                                        $curriculum->pivot->section_id,
                                                    ),
                                                );
                                            @endphp

                                            @if ($section && $section->gradeLevel)
                                                @role('admin')
                                                    <a href="{{ route('sections.show', $section->gradeLevel) }}">
                                                        {{ $section->name }}
                                                    </a>
                                                @endrole
                                                @role('teacher|parent|student')
                                                    {{ $section->name }}
                                                @endrole
                                            @else
                                                N/A
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    {{-- Parent --}}
                    @if ($user->hasRole('parent'))
                        <div class="d-flex align-items-center my-4 position-relative">
                            <h4 class="mx-auto mb-0">Children</h4>

                            @role('admin')
                                <a href="#" class="btn btn-sm btn-outline-primary position-absolute end-1"
                                    data-bs-toggle="modal" data-bs-target="#enrollChildModal">
                                    + Enroll Child
                                </a>
                            @endrole
                        </div>

                        <table id="children" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->children as $child)
                                    <tr>
                                        <td class="text-center">{{ $child->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('users.show', $child) }}">{{ $child->name }}</a>
                                        </td>
                                        <td class="text-center">{{ $child->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    {{-- Teacher --}}
                    @if ($user->hasRole('teacher'))
                        <h4 class="text-center my-4">Teaching In</h4>
                        <table id="grades" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teacherSubjects as $subject)
                                    <tr>
                                        <td class="text-center">{{ $subject->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('subjects.show', $subject) }}">{{ $subject->name }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a
                                                href="{{ route('grade-levels.show', \App\Models\GradeLevel::find($subject->pivot->grade_level_id)->slug) }}">
                                                {{ optional(\App\Models\GradeLevel::find($subject->pivot->grade_level_id))->name }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Enroll Child Modal --}}
    <div class="modal fade" id="enrollChildModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('users.store-child', $user) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Enroll Child for {{ $user->name }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="child-fields">
                            <div class="input-group input-group-outline my-3">
                                <label for="child_name" class="form-label">Child Name</label>
                                <input type="text" name="name" id="child_name" class="form-control" required>
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <label for="child_email" class="form-label">Child Email</label>
                                <input type="email" name="email" id="child_email" class="form-control" required>
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <select name="curriculum_id" id="curriculum_id" class="form-control curriculum-select">
                                    <option selected disabled>Select Curriculum</option>
                                    @foreach ($curriculums as $curriculum)
                                        <option value="{{ $curriculum->id }}">{{ $curriculum->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <select name="grade_level_id" id="grade_level_id" class="form-control grade-select">
                                    <option selected disabled>Select Grade Level</option>
                                    @foreach ($gradeLevels as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <select name="section_id" id="section_id" class="form-control section-select" disabled>
                                    <option selected disabled>Select Section</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Enroll Child</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $.fn.dataTable.ext.errMode = 'none';

        let tableGrades = new DataTable('#grades', {
            responsive: true,
            language: {
                emptyTable: "No grades found."
            }
        });

        let tableParents = new DataTable('#parents', {
            responsive: true
        });

        let tableStudent = new DataTable('#student', {
            responsive: true,
            language: {
                emptyTable: "No info found."
            }
        });

        let tableChildern = new DataTable('#children', {
            responsive: true
        });

        const gradeSections = @json($gradeSections);

        // Helper to init select2 on given jQuery element(s)
        function initSelect2($els) {
            $els.select2({
                allowClear: true,
                width: '100%',
                placeholder: ''
            });
        }

        // Initialize any existing selects on page load (non-modal ones)
        initSelect2($('.curriculum-select').not('#enrollChildModal .curriculum-select'));
        initSelect2($('.grade-select').not('#enrollChildModal .grade-select'));
        initSelect2($('.section-select').not('#enrollChildModal .section-select'));

        // Initialize selects inside modal when modal is shown (avoids hidden-initialization issues)
        $('#enrollChildModal').on('shown.bs.modal', function() {
            const $modal = $(this);
            initSelect2($modal.find('.curriculum-select'));
            initSelect2($modal.find('.grade-select'));
            initSelect2($modal.find('.section-select'));
        });

        // Use delegated jQuery handler so Select2's events (which use jQuery) are caught reliably.
        $(document).on('change', '.grade-select', function() {
            const $grade = $(this);
            const gradeId = $grade.val();
            const $sectionSelect = $grade.closest('.child-fields').find('.section-select');

            if (!$sectionSelect.length) return;

            // Destroy existing select2 instance (safe even if not initialized)
            try {
                $sectionSelect.select2('destroy');
            } catch (err) {
                /* ignore if not initialized */
            }

            // Clear and add default placeholder option
            $sectionSelect.empty().append($('<option selected disabled>').text('Select Section'));

            const sections = gradeSections[gradeId] || [];

            if (sections.length) {
                // Ensure select is enabled before re-init so select2 pick it up
                $sectionSelect.prop('disabled', false);

                sections.forEach(s => {
                    $sectionSelect.append($('<option>').val(s.id).text(s.name));
                });
            } else {
                $sectionSelect.prop('disabled', true);
            }

            // Reinitialize Select2 for the section select inside the same child-fields block
            initSelect2($sectionSelect);

            // Ensure the Select2 widget visually updates and has no selection
            $sectionSelect.val(null).trigger('change.select2');
        });
    </script>
@endsection
