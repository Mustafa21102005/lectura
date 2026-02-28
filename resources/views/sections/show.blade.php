@extends('layouts.dashboard')

@section('title', 'Manage Sections')

@section('page_header', 'Manage Sections')

@section('content')
    <div class="container my-auto">
        <div class="row">
            <div class="col-12">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Manage Sections</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        <x-error-alert />

                        <h4 class="font-weight-bolder text-center mb-0">
                            {{ "Manage Sections for {$gradeLevel->name}" }}
                        </h4>

                        <form method="POST" action="{{ route('sections.manage', $gradeLevel) }}">
                            @csrf

                            {{-- Sections --}}
                            <div id="section-boxes" class="d-flex flex-wrap gap-2 mt-4 justify-content-center"></div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary me-2">Save Changes</button>
                                <x-cancel-button :route="route('sections.index')" />
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
            const $sectionBoxes = $('#section-boxes');
            const possibleSections = @json($possibleSections); // ['A','B','C','D']
            const existingSections = @json($existingSections).map(s => s.trim().toUpperCase());

            // Render section buttons
            $sectionBoxes.empty();

            $.each(possibleSections, function(_, letter) {
                const isExisting = existingSections.includes(letter.toUpperCase());

                const $label = $('<label>')
                    .addClass('btn m-1 section-btn')
                    .addClass(isExisting ? 'btn-primary' : 'btn-outline-primary')
                    .text(`Section ${letter}`);

                const $checkbox = $('<input>')
                    .attr({
                        type: 'checkbox',
                        name: 'sections[]',
                        value: letter,
                        checked: isExisting
                    })
                    .addClass('d-none');

                $label.append($checkbox);
                $sectionBoxes.append($label);
            });

            // Delegate click event to all labels inside sectionBoxes
            $sectionBoxes.on('click', '.section-btn', function(e) {
                e.preventDefault();
                const $label = $(this);
                const $checkbox = $label.find('input[type="checkbox"]');

                $label.toggleClass('btn-primary btn-outline-primary');
                $checkbox.prop('checked', $label.hasClass('btn-primary'));
            });
        });
    </script>
@endsection
