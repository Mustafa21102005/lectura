@props(['classes' => ''])

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'alert alert-danger alert-dismissible text-white ' . $classes]) }}
        role="alert">
        <ul class="mb-0 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
