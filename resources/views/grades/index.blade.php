@extends('layouts.dashboard')

@section('title', 'Grades')

@section('page_header', 'Grades')

@section('content')
    <div class="row">
        <div class="col-12">

            {{-- Error Message --}}
            <x-error-alert class="mb-5" />

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h5 class="text-white text-capitalize ps-3">Grades table</h5>
                    </div>
                </div>

                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">
                        <table id="grades" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Assignment
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Student
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Mark
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Remarks
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grades as $grade)
                                    <tr>
                                        <td class="text-center">{{ $grade->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('assignments.show', $grade->submission->assignment) }}">
                                                {{ $grade->submission->assignment->title }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('users.show', $grade->student) }}">
                                                {{ $grade->student->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ $grade->score }}/{{ $grade->submission->assignment->max_score }}
                                        </td>
                                        <td class="text-center">
                                            {{ Str::limit($grade->remarks ?? 'No remarks', 30) . '...' }}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning mt-3 me-1" data-bs-toggle="modal"
                                                data-bs-target="#editGradeModal{{ $grade->id }}">
                                                Edit
                                            </button>
                                            <a class="btn bg-gradient-info mt-3"
                                                href="{{ route('grades.show', $grade->id) }}">
                                                View
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @foreach ($grades as $grade)
                            {{-- Modal --}}
                            <div class="modal fade" id="editGradeModal{{ $grade->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('grades.update', $grade) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Grade</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="input-group input-group-outline my-3">
                                                    <label class="form-label">Score</label>
                                                    <input type="number" name="score" class="form-control" min="0"
                                                        max="{{ $grade->submission->assignment->max_score }}"
                                                        value="{{ $grade->score }}" required>
                                                </div>

                                                <small class="text-muted">Maximum Mark:
                                                    {{ $grade->submission->assignment->max_score }}</small>

                                                <div class="input-group input-group-outline my-3">
                                                    <textarea name="remarks" class="form-control" rows="3" placeholder="Add feedback...">{{ $grade->remarks }}</textarea>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $.fn.dataTable.ext.errMode = 'none'; // disables console warnings

        let table = new DataTable('#grades', {
            responsive: true,
            language: {
                emptyTable: "No grades found."
            }
        });

        // Autofocus and select the score input when any modal opens
        document.querySelectorAll('.modal').forEach(modalEl => {
            modalEl.addEventListener('shown.bs.modal', () => {
                // find the input named "score" inside this modal
                const scoreInput = modalEl.querySelector('input[name="score"]');

                if (!scoreInput) return;

                // Small timeout to be extra-safe across browsers
                setTimeout(() => {
                    try {
                        // focus and select value so typing replaces existing score
                        scoreInput.focus({
                            preventScroll: true
                        });
                        scoreInput.select();
                    } catch (e) {
                        // fallback for older browsers
                        scoreInput.focus();
                        scoreInput.setSelectionRange(0, scoreInput.value.length);
                    }
                }, 10);
            });
        });
    </script>
@endsection
