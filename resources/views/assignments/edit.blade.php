@extends('layouts.dashboard')

@section('title', 'Edit Assignment')

@section('page_header', 'Edit Assignment')

@section('content')
    <div class="container my-auto">
        <div class="row">
            <div class="col-12">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Edit Assignment</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- Error Alert --}}
                        <x-error-alert />

                        <form role="form" method="POST" action="{{ route('assignments.update', $assignment) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Title --}}
                            <div class="input-group input-group-outline my-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    value="{{ old('title', $assignment->title) }}" required>
                            </div>

                            {{-- Description --}}
                            <div class="input-group input-group-outline my-3">
                                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Description">{{ old('description', $assignment->description) }}</textarea>
                            </div>

                            {{-- Subject --}}
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
                                            {{ old('subject_grade', $selectedValue ?? '') == $value ? 'selected' : '' }}>
                                            {{ $data['subject_name'] }} ({{ $data['grade_name'] }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="grade_level_id" id="grade_level_id">

                            {{-- Due Date --}}
                            <div class="input-group input-group-outline my-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="datetime-local" id="due_date" name="due_date" class="form-control"
                                    value="{{ old('due_date', $assignment->due_date->format('Y-m-d\TH:i')) }}" required>
                            </div>

                            {{-- Max Score --}}
                            <div class="input-group input-group-outline my-3">
                                <label for="max_score" class="form-label">Maximum Score</label>
                                <input type="number" id="max_score" name="max_score" class="form-control"
                                    value="{{ old('max_score', $assignment->max_score) }}" min="1" max="100"
                                    required>
                            </div>

                            {{-- File Upload --}}
                            <div class="input-group input-group-outline my-3">
                                <input type="file" name="file" id="files" class="form-control" multiple>
                            </div>

                            <input type="hidden" name="uploaded_files" id="uploaded_files">

                            {{-- Display existing files --}}
                            <div class="my-3">
                                <h6>Existing Files</h6>

                                @if ($files->isNotEmpty())
                                    <ul class="list-group">
                                        @foreach ($files as $file)
                                            @php
                                                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                                            @endphp
                                            <li
                                                class="list-group-item d-flex flex-column flex-md-row align-items-start gap-3">
                                                {{-- Preview --}}
                                                <div class="preview-wrapper" style="width:300px; max-width:35%;">
                                                    <div class="file-preview border rounded p-2 text-center"
                                                        style="min-height:100px; background-color:#f9f9f9;">
                                                        @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg']))
                                                            <img src="{{ $file['url'] }}" class="img-fluid rounded"
                                                                style="max-height:240px; object-fit:contain;"
                                                                alt="{{ $file['name'] }}">
                                                        @elseif(in_array($ext, ['mp4', 'webm', 'ogg', 'mov']))
                                                            <video controls class="w-100 rounded" style="max-height:240px;">
                                                                <source src="{{ $file['url'] }}"
                                                                    type="video/{{ $ext }}">
                                                                Your browser does not support video playback.
                                                            </video>
                                                        @elseif($ext === 'pdf')
                                                            <object data="{{ $file['url'] }}" type="application/pdf"
                                                                width="100%" height="300px" class="border-0 rounded">
                                                                <p class="text-muted">PDF preview unavailable — <a
                                                                        href="{{ $file['url'] }}" download>Download</a>.
                                                                </p>
                                                            </object>
                                                        @else
                                                            <p class="text-muted mt-3">Preview not available for this file
                                                                type.</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- File name & delete --}}
                                                <div class="flex-grow-1 mt-3 mt-md-0">
                                                    <h6 class="mb-2">
                                                        <a href="{{ $file['url'] }}" download
                                                            class="text-decoration-none text-primary fw-bold">
                                                            {{ $file['name'] }}
                                                        </a>
                                                    </h6>
                                                    <small class="text-muted">Size:
                                                        {{ number_format($file['size'] / 1024, 2) }} KB</small>
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger ms-2 mt-2 delete-file-btn"
                                                        data-id="{{ $file['id'] }}">
                                                        Delete
                                                    </button>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">No files uploaded yet.</p>
                                @endif
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary me-2">Update</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            $('#subject_grade').select2({
                allowClear: true
            });

            const subjectGradeMap = @json($subjects->mapWithKeys(fn($s) => [$s->id => $s->grade_levels]));

            $('#subject_grade').on('change', function() {
                const val = $(this).val();
                const parts = val.split('_');
                const subjectId = parts[0];
                const gradeLevelId = parts[1];

                $('#grade_level_id').val(JSON.stringify([gradeLevelId]));
            });

            // ================= FilePond =================
            FilePond.registerPlugin(FilePondPluginFileValidateType);

            const inputElement = document.querySelector('#files');

            FilePond.create(inputElement, {
                allowMultiple: true,
                allowRevert: true,
                allowPreview: true,
                acceptedFileTypes: [
                    'application/pdf', 'image/*', 'video/mp4', 'audio/*'
                ],
                labelIdle: 'Drag & Drop files or <span class="filepond--label-action">Browse</span>',
                server: {
                    process: {
                        url: '/uploads',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        onload: (response) => {
                            const data = JSON.parse(response);
                            let uploaded = document.getElementById('uploaded_files').value;
                            let list = uploaded ? JSON.parse(uploaded) : [];
                            list.push(data);
                            document.getElementById('uploaded_files').value = JSON.stringify(list);
                            return data.folder;
                        },
                        onerror: (response) => console.error('Upload failed', response)
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
                        }).then(() => load()).catch(() => error('Could not revert file'));
                    }
                }
            });

            // ================= Delete Media =================
            const deleteButtons = document.querySelectorAll('.delete-file-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const mediaId = this.dataset.id;

                    if (!confirm('Are you sure you want to delete this file?')) return;

                    fetch(`/assignments/media/${mediaId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.closest('li').remove();
                            } else {
                                alert('Failed to delete the file.');
                            }
                        })
                        .catch(() => alert('Failed to delete the file.'));
                });
            });
        });
    </script>
@endsection
