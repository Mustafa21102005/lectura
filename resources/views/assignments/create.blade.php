@extends('layouts.dashboard')

@section('title', 'Create Assignment')

@section('page_header', 'Create Assignment')

@section('content')
    <div class="container my-auto">
        <div class="row">
            <div class="col-12">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Create Assignment</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Error Alert --}}
                        <x-error-alert />

                        <form role="form" method="POST" action="{{ route('assignments.store') }}">
                            @csrf

                            {{-- Assignment Title --}}
                            <div class="input-group input-group-outline my-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" id="title" name="title" class="form-control" required
                                    value="{{ old('title') }}">
                            </div>

                            {{-- Assignment Description --}}
                            <div class="input-group input-group-outline my-3">
                                <textarea name="description" id="description" class="form-control" style="min-height: 50px;" rows="5"
                                    placeholder="Description">{{ old('description') }}</textarea>
                            </div>

                            {{-- Assignment File --}}
                            <div class="input-group input-group-outline my-3">
                                <input type="file" id="files" name="file" class="form-control" multiple required
                                    enctype="multipart/form-data">
                            </div>

                            {{-- For Filepond --}}
                            <input type="hidden" name="uploaded_files" id="uploaded_files">

                            {{-- Assignment Subject --}}
                            <div class="input-group input-group-outline my-3">
                                <select name="subject_grade" id="subject_grade" class="form-control select2" required>
                                    <option selected disabled>Select a Subject</option>

                                    @php
                                        $options = collect();
                                        foreach ($subjects as $subject) {
                                            foreach ($subject->grade_levels as $gradeLevelId) {
                                                $key = $subject->id . '_' . $gradeLevelId;
                                                $options[$key] = [
                                                    'subject_name' => $subject->name,
                                                    'grade_name' =>
                                                        \App\Models\GradeLevel::find($gradeLevelId)->name ?? 'N/A',
                                                ];
                                            }
                                        }
                                    @endphp

                                    @foreach ($options as $value => $data)
                                        <option value="{{ $value }}"
                                            {{ old('subject_grade') == $value ? 'selected' : '' }}>
                                            {{ $data['subject_name'] }} ({{ $data['grade_name'] }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="grade_level_id" id="grade_level_id">

                            {{-- Assignment Due Date --}}
                            <div class="input-group input-group-outline my-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="datetime-local" id="due_date" name="due_date" class="form-control" required
                                    value="{{ old('due_date', now()->format('Y-m-d\TH:i')) }}">
                            </div>

                            {{-- Assignment Max Score --}}
                            <div class="input-group input-group-outline my-3">
                                <label for="max_score" class="form-label">Max Score</label>
                                <input type="number" id="max_score" name="max_score" class="form-control" required
                                    min="1" max="100" value="{{ old('max_score') }}">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary me-2">Create</button>
                                <x-cancel-button :route="route('assignments.index')" />
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
            $('#subject_grade').select2({
                allowClear: true
            });
        });

        const subjectGradeMap = @json($subjects->mapWithKeys(fn($s) => [$s->id => $s->grade_levels]));
        $('#subject_grade').on('change', function() {
            const val = $(this).val();
            const parts = val.split('_');
            const subjectId = parts[0];
            const gradeLevelId = parts[1];

            $('#subject_id').val(subjectId); // set subject
            $('#grade_level_id').val(JSON.stringify([gradeLevelId])); // store as JSON
        });

        FilePond.registerPlugin(FilePondPluginFileValidateType);

        const inputElement = document.querySelector('input[type="file"]');

        const pond = FilePond.create(inputElement, {
            allowMultiple: true,
            allowRevert: true,
            allowPreview: true,
            acceptedFileTypes: [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'image/*',
                'video/mp4',
                'audio/*'
            ],
            fileValidateTypeLabelExpectedTypesMap: {
                'application/pdf': '.pdf',
                'application/msword': '.doc',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document': '.docx',
                'application/vnd.ms-powerpoint': '.ppt',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation': '.pptx',
                'application/vnd.ms-excel': '.xls',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': '.xlsx',
                'image/*': 'image',
                'video/mp4': 'mp4',
                'audio/*': 'audio'
            },
            labelIdle: 'Drag & Drop files or <span class="filepond--label-action">Browse</span>',
            server: {
                process: {
                    url: '/uploads',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    withCredentials: false,
                    onload: (response) => {
                        const data = JSON.parse(response);

                        // Save uploaded file info to hidden input
                        let uploaded = document.getElementById('uploaded_files').value;
                        let list = uploaded ? JSON.parse(uploaded) : [];
                        list.push(data);
                        document.getElementById('uploaded_files').value = JSON.stringify(list);

                        return data.folder;
                    },
                    onerror: (response) => {
                        console.error('Upload failed', response);
                    }
                },
                revert: (uniqueFileId, load, error) => {
                    let uploadedInput = document.getElementById('uploaded_files');
                    let uploadedList = uploadedInput.value ? JSON.parse(uploadedInput.value) : [];

                    uploadedList = uploadedList.filter(file => file.folder !== uniqueFileId);
                    uploadedInput.value = JSON.stringify(uploadedList);

                    fetch(`/uploads/revert/${uniqueFileId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => {
                        load();
                    }).catch(() => {
                        error('Could not revert file');
                    });
                }
            }
        });
    </script>
@endsection
