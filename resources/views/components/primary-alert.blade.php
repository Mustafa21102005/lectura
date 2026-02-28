@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-primary alert-dismissible text-white']) }} role="alert">
        <span class="text-sm">{{ $status }}</span>
        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
