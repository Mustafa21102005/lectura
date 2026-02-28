@extends('layouts.dashboard')

@section('title', 'Create Study Material')

@section('page_header', 'Create Study Material')

@section('content')
    <div class="container my-auto">
        <div class="row">
            <div class="col-12">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Create Study Material</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Error Alert --}}
                        <x-error-alert />

                        <form role="form" method="POST" action="{{ route('study-materials.store') }}">
                            @csrf

                            {{-- Study Material Title --}}
                            <div class="input-group input-group-outline my-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" id="title" name="title" class="form-control" required
                                    value="{{ old('title') }}">
                            </div>

                            {{-- Study Material Description --}}
                            <div class="input-group input-group-outline my-3">
                                <textarea name="description" id="description" class="form-control" style="min-height: 50px;" rows="5"
                                    placeholder="Description">{{ old('description') }}</textarea>
                            </div>

                            {{-- Study Material File --}}
                            <div class="input-group input-group-outline my-3">
                                <input type="file" id="files" name="file" class="form-control" multiple required
                                    enctype="multipart/form-data">
                            </div>

                            {{-- For Filepond --}}
                            <input type="hidden" name="uploaded_files" id="uploaded_files">

                            {{-- Study Material Subject --}}
                            <div class="input-group input-group-outline my-3">
                                <select name="subject_id" id="subject_id" class="form-control" required>
                                    <option selected disabled>Select Subject</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                            {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                            ({{ \App\Models\GradeLevel::find($subject->pivot->grade_level_id)->name ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="grade_level_id" id="grade_level_id">

                            {{-- Study Material Type --}}
                            <div class="input-group input-group-outline my-3">
                                <select name="material_type_id" id="material_type_id" class="form-control" required>
                                    <option selected disabled>Select Material Type</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ old('material_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary me-2">Create</button>
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

        const subjectGradeMap = @json(
            $subjects->mapWithKeys(fn($s) => [
                    $s->id => $s->gradeLevels->pluck('id')->toArray(),
                ]));

        $('#subject_id').on('change', function() {
            const subjectId = $(this).val();
            const gradeLevelIds = subjectGradeMap[subjectId] || [];
            $('#grade_level_id').val(JSON.stringify(gradeLevelIds));
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

                        return data.folder; // required by FilePond
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
