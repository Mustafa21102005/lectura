@extends('layouts.dashboard')

@section('title', 'Create User')

@section('page_header', 'Create User')

@section('css')
    <style>
        .fade {
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.5s ease-in-out;
        }

        .fade.show {
            opacity: 1;
            max-height: 1000px;
        }
    </style>
@endsection

@section('content')
    <div class="container my-auto">
        <div class="row">
            <div class="col-12">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Create User</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Error Alert --}}
                        <x-error-alert />

                        <form role="form" method="POST" action="{{ route('users.store') }}">
                            @csrf
                            <div class="input-group input-group-outline my-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" required
                                    value="{{ old('name') }}">
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required
                                    value="{{ old('email') }}">
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    value="{{ old('phone') }}">
                            </div>

                            <div class="input-group input-group-outline my-3">
                                <select class="form-control" id="role_id" name="role_id" required>
                                    <option selected disabled>Select Role</option>
                                    <option value="parent">Parent</option>
                                    <option value="admin">Admin</option>
                                    <option value="teacher">Teacher</option>
                                </select>
                            </div>

                            {{-- Children Info for Parent --}}
                            <div id="children-info" class="fade ps-1">
                                <h5>Children Information</h5>
                                <div id="children-container">
                                    <div class="child-fields border p-3 mb-3 rounded">
                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Child Name</label>
                                            <input type="text" name="children[0][name]" class="form-control">
                                        </div>
                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Child Email</label>
                                            <input type="email" name="children[0][email]" class="form-control">
                                        </div>
                                        <div class="input-group input-group-outline my-3">
                                            <select class="form-control" name="children[0][curriculum_id]">
                                                <option selected disabled>Select Curriculum</option>
                                                @foreach ($curriculums as $curriculum)
                                                    <option value="{{ $curriculum->id }}">
                                                        {{ $curriculum->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group input-group-outline my-3">
                                            <select class="form-control grade-select" name="children[0][grade_level_id]"
                                                required>
                                                <option selected disabled>Select Grade</option>
                                                @foreach ($gradeLevels as $grade)
                                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="input-group input-group-outline my-3">
                                            <select class="form-control section-select" name="children[0][section_id]"
                                                required disabled>
                                                <option selected disabled>Select Section</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="button" id="add-child" class="btn btn-sm btn-outline-primary">
                                        + Add Another Child
                                    </button>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary me-2">Create</button>
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
        $(function() {

            const $role = $('#role_id');
            const $childrenInfo = $('#children-info');
            const $childrenContainer = $('#children-container');

            let childIndex = 1;

            const gradeSections = @json($gradeSections);

            $role.select2({
                width: '100%',
                placeholder: 'Select Role',
                allowClear: true
            });

            function toggleChildrenSection(role) {
                if (role && role.toLowerCase() === 'parent') {
                    $childrenInfo.addClass('show');
                } else {
                    $childrenInfo.removeClass('show');
                }
            }

            toggleChildrenSection($role.val());

            $role.on('change', function() {
                toggleChildrenSection($(this).val());
            });

            function populateSections($gradeSelect) {
                const gradeId = $gradeSelect.val();
                const $sectionSelect = $gradeSelect
                    .closest('.child-fields')
                    .find('.section-select');

                $sectionSelect
                    .html('<option selected disabled>Select Section</option>')
                    .prop('disabled', true);

                if (gradeSections[gradeId]) {
                    $.each(gradeSections[gradeId], function(_, section) {
                        $sectionSelect.append(
                            $('<option>', {
                                value: section.id,
                                text: section.name
                            })
                        );
                    });

                    $sectionSelect.prop('disabled', false);
                }
            }

            $('#add-child').on('click', function() {

                const childTemplate = `
                    <div class="child-fields border p-3 mb-3 rounded fade">
                        <div class="position-relative">
                            <button type="button"
                                class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 me-2 remove-child">
                                <i class="material-icons me-2 fs-6 lh-base">delete</i>
                                <span>Remove</span>
                            </button>
                        </div>

                        <div class="input-group input-group-outline my-3 mt-5">
                            <label class="form-label">Child Name</label>
                            <input type="text" name="children[${childIndex}][name]" class="form-control">
                        </div>

                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Child Email</label>
                            <input type="email" name="children[${childIndex}][email]" class="form-control">
                        </div>

                        <div class="input-group input-group-outline my-3">
                            <select class="form-control" name="children[${childIndex}][curriculum_id]">
                                <option selected disabled>Select Curriculum</option>
                                @foreach ($curriculums as $curriculum)
                                    <option value="{{ $curriculum->id }}">{{ $curriculum->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group input-group-outline my-3">
                            <select class="form-control grade-select"
                                name="children[${childIndex}][grade_level_id]" required>
                                <option selected disabled>Select Grade</option>
                                @foreach ($gradeLevels as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group input-group-outline my-3">
                            <select class="form-control section-select"
                                name="children[${childIndex}][section_id]" required disabled>
                                <option selected disabled>Select Section</option>
                            </select>
                        </div>
                    </div>
                `;

                const $newChild = $(childTemplate).appendTo($childrenContainer);

                requestAnimationFrame(() => {
                    $newChild.addClass('show');
                });

                childIndex++;
            });

            $(document).on('focus', '.input-group-outline input, .input-group-outline select', function() {
                $(this).closest('.input-group-outline').addClass('is-focused');
            });

            $(document).on('blur', '.input-group-outline input, .input-group-outline select', function() {
                const $group = $(this).closest('.input-group-outline');
                $group.removeClass('is-focused');

                if ($(this).val()) {
                    $group.addClass('is-filled');
                } else {
                    $group.removeClass('is-filled');
                }
            });

            $childrenContainer.on('click', '.remove-child', function() {
                const $child = $(this).closest('.child-fields');
                $child.removeClass('show');
                $child.one('transitionend', function() {
                    $(this).remove();
                });
            });

            $childrenContainer.on('change', '.grade-select', function() {
                populateSections($(this));
            });

        });
    </script>
@endsection
