@extends('layouts.dashboard')

@section('title', 'Study Material')

@section('page_header', 'Study Material')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h5 class="text-white text-capitalize ps-3">Study Material</h5>

                        @role('student')
                            <x-back-button :href="route('student.study-materials.index')">
                                My Study Materials
                            </x-back-button>
                        @endrole
                        @role('parent')
                            <x-back-button :href="route('parent.study-materials.index')">
                                Child Study Materials
                            </x-back-button>
                        @endrole
                        @role('admin|teacher')
                            <x-back-button :href="route('study-materials.index')">
                                Study Materials
                            </x-back-button>
                        @endrole
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <h4 class="text-center my-4">Study Material Details</h4>
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                @role('admin|teacher')
                                    <th scope="col"
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                @endrole
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Title
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Description
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Subject
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Teacher
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Material Type
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @role('admin|teacher')
                                    <td class="text-center">{{ $studyMaterial->id }}</td>
                                @endrole
                                <td class="text-center">{{ $studyMaterial->title }}</td>
                                <td class="text-center text-wrap">
                                    {{ $studyMaterial->description ?? 'No Description' }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('subjects.show', $studyMaterial->subject) }}">
                                        {{ $studyMaterial->subject->name }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    {{ $studyMaterial->teacher->name }}
                                </td>
                                <td class="text-center">
                                    @role('admin|teacher')
                                        <a href="{{ route('material-types.show', $studyMaterial->type) }}">
                                            {{ $studyMaterial->type->name }}
                                        </a>
                                    @endrole
                                    @role('parent|student')
                                        {{ $studyMaterial->type->name }}
                                    @endrole
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 class="text-center my-4">Media Files</h4>
                    @if ($media->isNotEmpty())
                        <table class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    @role('admin|teacher')
                                        <th
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            ID
                                        </th>
                                    @endrole
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        File Name
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        View / Download
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($media as $file)
                                    <tr>
                                        @role('admin|teacher')
                                            <td class="text-center">{{ $file['id'] }}</td>
                                        @endrole
                                        <td class="text-center">{{ $file['name'] }}</td>
                                        <td class="text-center">
                                            <a href="{{ $file['url'] }}" target="_blank"
                                                class="btn btn-sm btn-primary mt-3">
                                                View
                                            </a>
                                            <a href="{{ $file['url'] }}" download class="btn btn-sm btn-secondary mt-3">
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted text-center">No media files uploaded yet.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
