@extends('layouts.dashboard')

@section('title', 'Edit Study Material')

@section('page_header', 'Edit Study Material')

@section('content')
    <div class="container my-auto">
        <div class="row">
            <div class="col-12">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Edit Study Material</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <x-error-alert />

                        <form role="form" method="POST" action="{{ route('study-materials.update', $studyMaterial) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Title --}}
                            <div class="input-group input-group-outline my-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    value="{{ old('title', $studyMaterial->title) }}" required>
                            </div>

                            {{-- Description --}}
                            <div class="input-group input-group-outline my-3">
                                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Description">
                                    {{ old('description', $studyMaterial->description) }}
                                </textarea>
                            </div>

                            {{-- Subject --}}
                            <div class="input-group input-group-outline my-3">
                                <select class="form-control" id="subject_id" name="subject_id" required>
                                    <option disabled>Select Subject</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                            {{ $studyMaterial->subject_id == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                            ({{ \App\Models\GradeLevel::find($subject->pivot->grade_level_id)->name ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Material Type --}}
                            <div class="input-group input-group-outline my-3">
                                <select class="form-control" id="material_type_id" name="material_type_id" required>
                                    <option disabled>Select Material Type</option>
                                    @foreach ($materialTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ $studyMaterial->material_type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- File --}}
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
                                                            <p class="text-muted mt-3">
                                                                Preview not available for this file type.
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- File name & download --}}
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
                                <x-cancel-button :route="route('study-materials.index')" />
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
        $('#material_type_id, #subject_id').select2({
            allowClear: true,
            width: '100%',
            placeholder: ''
        });

        document.addEventListener('DOMContentLoaded', function() {
            // ================= FilePond =================
            FilePond.registerPlugin(FilePondPluginFileValidateType);

            const inputElement = document.querySelector('#files');

            FilePond.create(inputElement, {
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

                    fetch(`/study-materials/media/${mediaId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.closest('li').remove(); // remove from UI
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
