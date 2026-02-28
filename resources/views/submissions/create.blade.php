@extends('layouts.dashboard')

@section('title', 'Assignment Submission')

@section('page_header', 'Assignment Submission')

@section('content')
    <div class="container my-auto">
        <div class="row">
            <div class="col-12">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Assignment Submission</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Error Alert --}}
                        <x-error-alert />

                        <form role="form" method="POST" action="{{ route('submissions.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- Hidden assignment ID --}}
                            <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">

                            {{-- Remarks --}}
                            <div class="input-group input-group-outline my-3">
                                <textarea name="remarks" id="remarks" class="form-control" style="min-height: 50px;" rows="5"
                                    placeholder="Any remarks or notes for the teacher...">{{ old('remarks') }}</textarea>
                            </div>

                            {{-- Assignment File --}}
                            <div class="input-group input-group-outline my-3">
                                <input type="file" id="files" name="file" class="form-control" multiple required>
                            </div>

                            {{-- For Filepond --}}
                            <input type="hidden" name="uploaded_files" id="uploaded_files">

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary me-2">Submit</button>
                                <x-cancel-button :route="route('student.assignments.index')" />
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
